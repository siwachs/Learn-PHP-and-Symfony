<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1', name: 'app_customer_controller')]
class CustomerController extends AbstractController
{
    private $customerRepo;
    private $validator;
    private $entityManager;

    public function __construct(CustomerRepository $customerRepo, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $this->customerRepo = $customerRepo;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    private function isValidCustomer(Customer $customer)
    {
        $errors = $this->validator->validate($customer);


        if (count($errors) > 0) {
            return false;
        }

        return true;
    }

    #[Route('/get-customers', name: 'app_get_customers', methods: ['GET', 'HEAD'])]
    public function getCustomers(): JsonResponse
    {
        try {
            $customers = $this->customerRepo->findAll();
            $processedCustomers = [];
            foreach ($customers as $customer) {
                $processedCustomers[] = [
                    'email' => $customer->getEmail(),
                    'cartId' => $customer->getCart()->getId(),
                    'phoneNumber' => $customer->getPhoneNumber(),
                ];
            }

            return $this->json([
                "customers" => $processedCustomers,
                "success" => true,
                "error" => null
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                "customers" => null,
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/get-customer', name: 'app_get_customer', methods: ['GET', 'HEAD'])]
    public function getCustomer(Request $request): JsonResponse
    {
        try {
            $customerId = $request->query->get('email');
            if ($customerId === null) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Null email."
                ], 400);
            }

            $customer = $this->customerRepo->find($customerId);
            if ($customer === null) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Customer not found."
                ], 404);
            }

            return $this->json([
                "customers" => [
                    'email' => $customer->getEmail(),
                    'cartId' => $customer->getCart()->getId(),
                    'phoneNumber' => $customer->getPhoneNumber()
                ],
                "success" => true,
                "error" => null
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                "customer" => null,
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/remove-customer', name: 'app_remove_customer', methods: ['DELETE'])]
    public function removeCustomer(Request $request): JsonResponse
    {
        try {
            $customerId = $request->query->get('email');
            if ($customerId === null) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Null email."
                ], 400);
            }

            $customer = $this->customerRepo->find($customerId);
            if ($customer === null) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Customer not found."
                ], 404);
            }

            $this->entityManager->remove($customer);
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

    #[Route('/update-customer', name: 'app_update_customer', methods: ['PATCH'])]
    public function updateCustomer(Request $request): JsonResponse
    {
        try {
            $customerId = $request->query->get('email');
            $data = json_decode($request->getContent(), true);

            if ($customerId === null) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Null email."
                ], 400);
            }

            $customer = $this->customerRepo->find($customerId);
            if ($customer === null) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Customer not found."
                ], 404);
            }

            if (isset($data['email'])) {
                $customer->setEmail($data['email']);
            }

            if (isset($data['phoneNumber'])) {
                $customer->setPhoneNumber($data['phoneNumber']);
            }

            if (!$this->isValidCustomer($customer)) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Validation Error."
                ], 400);
            }

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return $this->json([
                "customer" => [
                    'email' => $customer->getEmail(),
                    'phoneNumber' => $customer->getPhoneNumber()
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

    #[Route('/create-customer', name: 'app_create_customer', methods: ['POST'])]
    public function createCustomer(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $customer = new Customer();
            $cart = new Cart();
            $customer->setEmail($data['email']);
            $customer->setPhoneNumber($data['phoneNumber']);
            $cart->setUpdatedAt(new \DateTimeImmutable());
            $customer->setCart($cart);

            if (!$this->isValidCustomer($customer)) {
                return $this->json([
                    "customer" => null,
                    "success" => false,
                    "error" => "Validation Error."
                ], 400);
            }

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return $this->json([
                "customer" => [
                    'email' => $customer->getEmail(),
                    'cartId' => $customer->getCart()->getId(),
                    'phoneNumber' => $customer->getPhoneNumber()
                ],
                "success" => true,
                "error" => null
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                "customer" => null,
                "success" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
