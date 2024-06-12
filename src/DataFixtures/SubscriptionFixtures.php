<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $subscriptionBasic = new Subscription();
        $subscriptionBasic->setTitle('Basic creation');
        $subscriptionBasic->setPrice(5.00);
        $subscriptionBasic->setDescription('L\'abonnement Basic Creator vous permet de créer des PDF simples à partir de diverses sources. Parfait pour les utilisateurs occasionnels qui ont besoin d\'outils de base pour leurs documents PDF.');
        $subscriptionBasic->setPdfLimit(5);
        $subscriptionBasic->setMedia('test');

        $manager->persist($subscriptionBasic);

        $subscriptionStandard = new Subscription();
        $subscriptionStandard->setTitle('Standard creation');
        $subscriptionStandard->setPrice(10.00);
        $subscriptionStandard->setDescription('L\'abonnement Standard Creator est idéal pour les utilisateurs réguliers qui nécessitent des fonctionnalités supplémentaires pour la création et la gestion de leurs PDF. Profitez d\'une flexibilité accrue avec plus d\'options de création.');
        $subscriptionStandard->setPdfLimit(20);
        $subscriptionStandard->setMedia('test');

        $manager->persist($subscriptionStandard);
        
        $subscriptionPremium = new Subscription();
        $subscriptionPremium->setTitle('Premium creation');
        $subscriptionPremium->setPrice(20.00);
        $subscriptionPremium->setDescription('L\'abonnement Premium Creator offre des fonctionnalités avancées pour les professionnels et les entreprises qui ont des besoins élevés en matière de création et de gestion de PDF. Accédez à des outils complets pour maximiser votre productivité.');
        $subscriptionPremium->setPdfLimit(100);
        $subscriptionPremium->setMedia('test');

        $manager->persist($subscriptionPremium);

        $manager->flush();
    }
}
