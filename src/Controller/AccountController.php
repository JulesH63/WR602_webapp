<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/app/account', name: 'app_account')]
    public function index(Request $request): Response
    {
        $user = $this->userRepository->find($this->getUser()->getId());
        $form = $this->createForm(UserType::class, $user);

        $edit = $request->query->get('edit') ?? false;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $this->userRepository->save($user, true);
            $this->addFlash('success', 'Votre compte a bien été mis à jour.');
            return $this->redirectToRoute('app_account');
        }

        $subscription = $user->getSubscription();

        return $this->render('account/index.html.twig', [
            'form' => $form->createView(),
            'edit' => $edit,
            'subscription' => $subscription,
        ]);
    }
}
