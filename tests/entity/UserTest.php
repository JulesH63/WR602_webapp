<?php
namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Subscription;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $user = new User();
        $subscription = new Subscription();

        $email = 'test@test.com';
        $lastname = 'Doe';
        $firstname = 'John';
        $password = 'password123';
        $role = 'ROLE_USER';
        $subscriptionEndAt = new \DateTime('2024-12-31');
        $createdAt = new \DateTime('2024-04-17');
        $updatedAt = new \DateTime();

        $user->setEmail($email);
        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setPassword($password);
        $user->setRole($role);
        $user->setSubscription($subscription);
        $user->setSubscriptionEndAt($subscriptionEndAt);
        $user->setCreatedAt($createdAt);
        $user->setUpdatedAt($updatedAt);

        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($role, $user->getRole());
        $this->assertEquals($subscription, $user->getSubscription());
        $this->assertEquals($subscriptionEndAt, $user->getSubscriptionEndAt());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
    }
}
