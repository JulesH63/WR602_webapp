<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\PdfType;
use App\Repository\PdfRepository;
use App\Service\PdfGenerateRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app/pdf', name: 'app_pdf')]
class GeneratePdfController extends AbstractController
{
    public function __construct(
        private PdfGenerateRequestService $pdfGenerateRequestService,
        private PdfRepository $pdfRepository
    ) {
    }

    #[Route('/url', name: '_url')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(PdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formDatas = $form->getData();
            $url = $formDatas->getUrl();

            $pdfContent = $this->pdfGenerateRequestService->requestToGeneratePdfFromUrl($url);

            if (!$pdfContent || str_contains($pdfContent, 'error')) {
                $this->addFlash('danger', 'Erreur lors de la génération du PDF.');

                return $this->redirectToRoute('app_pdf_url');
            }

            $fileName = 'pdf_' . uniqid() . '.pdf';
            $relativePath = 'pdf_repository/' . $fileName;
            $filePath = $this->getParameter('kernel.project_dir') . '/public/' . $relativePath;

            $directory = dirname($filePath);
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            file_put_contents($filePath, $pdfContent);

            $pdf = new Pdf();
            $pdf->setUrl($url);
            $pdf->setPath($relativePath); 
            $pdf->setTitle($formDatas->getTitle());
            $pdf->setCreatedAt(new \DateTimeImmutable());
            $pdf->setUser($this->getUser());

            $this->pdfRepository->save($pdf, true);

            return $this->redirectToRoute('app_pdf_url');
        }

        return $this->render('pdf/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
