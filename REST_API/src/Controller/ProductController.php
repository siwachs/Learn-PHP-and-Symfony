<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1', name: 'app_product_controller')]
class ProductController extends AbstractController
{
    private $productRepo;
    private $entityManager;
    private $validator;

    public function __construct(ProductRepository $productRepo, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->productRepo = $productRepo;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    private function isValidProduct(Product $product)
    {
        $errors = $this->validator->validate($product);


        if (count($errors) > 0) {
            return false;
        }

        return true;
    }

    #[Route('/get-products', name: 'app_get_products', methods: ['GET', 'HEAD'])]
    public function getProducts(): JsonResponse
    {
        try {
            $products = $this->productRepo->findAll();
            $processedProducts = [];
            foreach ($products as $product) {
                $processedProducts[] = [
                    'id' => $product->getId(),
                    'code' => $product->getCode(),
                    'title' => $product->getTitle(),
                    'price' => $product->getPrice()
                ];
            }

            return $this->json([
                "products" => $processedProducts,
                "success" => true,
                "error" => null
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                "products" => null,
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/get-product', name: 'app_get_product', methods: ['GET', 'HEAD'])]
    public function getProduct(Request $request): JsonResponse
    {
        try {
            $productId = $request->query->get('id');
            if ($productId === null) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Null Id."
                ], 400);
            }

            $product = $this->productRepo->find($productId);
            if ($product === null) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Product not found."
                ], 404);
            }

            return $this->json([
                "product" => [
                    'id' => $product->getId(),
                    'code' => $product->getCode(),
                    'title' => $product->getTitle(),
                    'price' => $product->getPrice()
                ],
                "success" => true,
                "error" => null
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                "product" => null,
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/remove-product', name: 'app_remove_product', methods: ['DELETE'])]
    public function removeProduct(Request $request): JsonResponse
    {
        try {
            $productId = $request->query->get('id');
            if ($productId === null) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Null Id."
                ], 400);
            }

            $product = $this->productRepo->find($productId);
            if ($product === null) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Product not found."
                ], 404);
            }

            $this->entityManager->remove($product);
            $this->entityManager->flush();

            return $this->json([
                "success" => true,
                "error" => null
            ], 204);
        } catch (\Exception $e) {
            return $this->json([
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/update-product', name: 'app_update_product', methods: ['PATCH'])]
    public function updateProduct(Request $request): JsonResponse
    {
        try {
            $productId = $request->query->get('id');
            $data = json_decode($request->getContent(), true);

            if ($productId === null) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Null Id."
                ], 400);
            }

            $product = $this->productRepo->find($productId);
            if ($product === null) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Product not found."
                ], 404);
            }

            if (isset($data['code'])) {
                $product->setCode($data['code']);
            }

            if (isset($data['title'])) {
                $product->setTitle($data['title']);
            }

            if (isset($data['price'])) {
                $product->setPrice($data['price']);
            }

            if (!$this->isValidProduct($product)) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Validation Error."
                ], 400);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->json([
                "product" => [
                    'id' => $product->getId(),
                    'code' => $product->getCode(),
                    'title' => $product->getTitle(),
                    'price' => $product->getPrice()
                ],
                "success" => true,
                "error" => null
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/create-product', name: 'app_create_product', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $product = new Product();
            $product->setCode($data['code']);
            $product->setTitle($data['title']);
            $product->setPrice($data['price']);

            if (!$this->isValidProduct($product)) {
                return $this->json([
                    "product" => null,
                    "success" => false,
                    "error" => "Validation Error."
                ], 400);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->json([
                "product" => [
                    'id' => $product->getId(),
                    'code' => $product->getCode(),
                    'title' => $product->getTitle(),
                    'price' => $product->getPrice()
                ],
                "success" => true,
                "error" => null
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                "product" => null,
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
