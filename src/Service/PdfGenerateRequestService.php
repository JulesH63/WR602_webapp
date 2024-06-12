<?php

namespace App\Service;

use App\Entity\Pdf;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfGenerateRequestService
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function requestToGeneratePdfFromUrl(string $url): string
    {
        $response = $this->client->request(
            'POST',
            $_ENV['MICROSERVICE_URL'] . '/pdf/download/url',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'url' => $url
                ]
            ]
        );

        return $response->getContent();
    }
}