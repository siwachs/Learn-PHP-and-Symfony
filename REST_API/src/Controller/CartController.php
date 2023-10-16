<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api/v1', name: 'app_cart_controller')]
class CartController extends AbstractController
{
    private $customerRepo;
    private $productRepo;
    private $entityManager;

    public function __construct(CustomerRepository $customerRepo, ProductRepository $productRepo, EntityManagerInterface $entityManager)
    {
        $this->customerRepo = $customerRepo;
        $this->productRepo = $productRepo;
        $this->entityManager = $entityManager;
    }

    #[Route('/remove-from-cart', name: 'app_remove_from_cart', methods: ['DELETE'])]
    public function removeFromCart(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $customer = $this->customerRepo->find($data['email']);
            $product = $this->productRepo->find($data['productId']);

            if (!$customer) {
                return $this->json([
                    "success" => false,
                    "error" => "Customer not found."
                ], 404);
            }

            if (!$product) {
                return $this->json([
                    "success" => false,
                    "error" => "Product not found."
                ], 404);
            }

            $cart = $customer->getCart();
            $products = $cart->getProducts();
            if (!$products->contains($product)) {
                return $this->json([
                    "success" => false,
                    "error" => "Product not found in the cart."
                ], 404);
            }

            $cart->setUpdatedAt(new \DateTimeImmutable());
            $cart->removeProduct($product);

            $this->entityManager->persist($cart);
            $this->entityManager->flush();

            return $this->json([
                "success" => true,
                "error" => null
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/add-to-cart', name: 'app_add_to_cart', methods: ['POST'])]
    public function addToCart(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $customer = $this->customerRepo->find($data['email']);
            $product = $this->productRepo->find($data['productId']);

            if (!$customer) {
                return $this->json([
                    "success" => false,
                    "error" => "Customer not found."
                ], 404);
            }

            if (!$product) {
                return $this->json([
                    "success" => false,
                    "error" => "Product not found."
                ], 404);
            }

            $cart = $customer->getCart();
            $cart->setUpdatedAt(new \DateTimeImmutable());
            $cart->addProduct($product);

            $this->entityManager->persist($cart);
            $this->entityManager->flush();

            return $this->json([
                "success" => true,
                "error" => null
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
