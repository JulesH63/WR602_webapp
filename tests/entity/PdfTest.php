<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Pdf;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        // Création instance entité Pdf et User
        $pdf = new Pdf();
        $user = new User();

        $title = 'PDF Title';
        $createdAt = new \DateTime('2024-04-17');

        $pdf->setTitle($title);
        $pdf->setUser($user);
        $pdf->setCreatedAt($createdAt);

        $this->assertSame($title, $pdf->getTitle());
        $this->assertSame($user, $pdf->getUser());
        $this->assertEquals($createdAt, $pdf->getCreatedAt());
    }
}
