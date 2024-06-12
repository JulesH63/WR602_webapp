<?php

namespace App\Tests\Entity;

use App\Entity\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        // Création instance entité Subscription
        $subscription = new Subscription();

        $title = 'Subscription Title';
        $description = 'Subscription Description';
        $pdfLimit = 10;
        $price = 9.99;
        $media = 'Subscription Media';

        $subscription->setTitle($title);
        $subscription->setDescription($description);
        $subscription->setPdfLimit($pdfLimit);
        $subscription->setPrice($price);
        $subscription->setMedia($media);

        $this->assertSame($title, $subscription->getTitle());
        $this->assertSame($description, $subscription->getDescription());
        $this->assertSame($pdfLimit, $subscription->getPdfLimit());
        $this->assertSame($price, $subscription->getPrice());
        $this->assertSame($media, $subscription->getMedia());
    }
}
