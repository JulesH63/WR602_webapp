<?php

namespace App\Controller;

use App\Repository\PdfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app')]
class PdfController extends AbstractController
{
    public function __construct(
        private PdfRepository $pdfRepository
    )
    {
    }

    #[Route('/galery', name: 'app_galery')]
    public function index(): Response
    {
        $user = $this->getUser();
        $pdfs = $this->pdfRepository->findBy(['user' => $user], ['created_at' => 'DESC']);

        return $this->render('galery/index.html.twig', [
            'pdfs' => $pdfs
        ]);
    }

    #[Route('/pdf/delete/{id}', name: 'app_pdf_delete')]
    public function delete($id): Response
    {
        $pdf = $this->pdfRepository->find($id);

        if ($pdf) {
            $this->pdfRepository->remove($pdf, true);
        }

        return $this->redirectToRoute('app_galery');
    }
}