<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app')]
class SubscriptionController extends AbstractController
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private UserRepository $userRepository,
    )
    {
    }

    #[Route('/subscribe/{id}', name: 'app_subscribe')]
    public function index(?int $id): Response
    {
        $subscription = $this->subscriptionRepository->find($id);
        $user = $this->getUser();
        
        $user->setSubscription($subscription);
        $this->userRepository->save($user, true);

        return $this->redirectToRoute('app_home');
    }
}