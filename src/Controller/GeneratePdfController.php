<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\PdfType;
use App\Repository\PdfRepository;
use App\Repository\UserRepository;
use App\Service\GeneratePdfService; // Assurez-vous que le service est correctement importé
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pdf', name: 'pdf')]
class GeneratePdfController extends AbstractController
{
    public function __construct(
        private GeneratePdfService $generatePdfService, // Modifiez le nom de la variable pour correspondre au nom du service
        private PdfRepository $pdfRepository,
        private UserRepository $userRepository
    )
    {
    }

    #[Route('/generate', name: 'generate')]
    public function generatePdfForm(Request $request): Response
    {
        $form = $this->createForm(PdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formDatas = $form->getData();
            $url = $formDatas->getUrl();

            $pdfCount = $this->pdfRepository->countPdfGeneratedByUserOnDate(
                $this->getUser()->getId(),
                new \DateTimeImmutable('today'),
                new \DateTimeImmutable('tomorrow')
            );
            $maxPdf = $this->userRepository->getMaxPdfByUser($this->getUser());

            if ($pdfCount >= $maxPdf) {
                $this->addFlash('danger', 'Vous avez atteint le nombre maximum de PDF générés pour aujourd\'hui.');

                return $this->redirectToRoute('pdf_generate');
            } else {
                // Appel du service GeneratePdfService qui va envoyer l'url du PDF au micro-service
                $pdfContent = $this->generatePdfService->requestToGeneratePdfFromUrl($url);

                // enregistrer le contenu du PDF dans un fichier dans le dossier pdf_repository de votre projet
                $fileName = 'pdf_' . uniqid() . '.pdf';
                $filePath = $_ENV['PDF_STORAGE_PATH'] . '/' . $fileName;
                file_put_contents($filePath, $pdfContent);

                // créer un objet Pdf et le sauvegarder en base de données
                $pdf = new Pdf();
                $pdf->setUrl($url);
                $pdf->setPath($filePath);
                $pdf->setTitle($formDatas->getTitle());
                $pdf->setCreatedAt(new \DateTimeImmutable());
                $pdf->setUser($this->getUser());

                $this->pdfRepository->save($pdf, true);

                return $this->redirectToRoute('pdf_generate_success', [
                    'url' => $url,
                    'path' => $_ENV['PDF_STORAGE_SRC'] . '/' . $fileName
                ]);
            }
        }

        return $this->render('pdf/generatePdf.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/generate/success', name: 'generate_success')]
    public function generatePdfSuccess(Request $request): Response
    {
        // Cette méthode est vide car elle ne nécessite pas de logique spécifique pour afficher la page de succès.
        return new Response('PDF généré avec succès !');
    }
}
