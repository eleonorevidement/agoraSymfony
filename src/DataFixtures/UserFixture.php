<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(

        private UserPasswordHasherInterface $hasher
    ){}
    public function load(ObjectManager $manager): void
    {
        #admins
        $admin1 = new User();
        $admin1->setEmail('eleonore.vidementdupouy@edu.ece.fr');
        $admin1->setFirstName('Eleonore');
        $admin1->setLastName('Videment');
        $admin1->setPassword($this->hasher->hashPassword($admin1, 'agora'));
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin2 = new User();
        $admin2->setEmail('cedric.gourhant@edu.ece.fr');
        $admin2->setFirstName('Cedric');
        $admin2->setLastName('Gourhant');
        $admin2->setPassword($this->hasher->hashPassword($admin2, 'agora'));
        $admin2->setRoles(['ROLE_ADMIN']);
        $admin3 = new User();
        $admin3->setEmail('luna.rondineau@edu.ece.fr');
        $admin3->setFirstName('Luna');
        $admin3->setLastName('Rondineau');
        $admin3->setPassword($this->hasher->hashPassword($admin3, 'agora'));
        $admin3->setRoles(['ROLE_ADMIN']);
        $admin4 = new User();
        $admin4->setEmail('halima.ghazi@edu.ece.fr');
        $admin4->setFirstName('Halima');
        $admin4->setLastName('Ghazi');
        $admin4->setPassword($this->hasher->hashPassword($admin4, 'agora'));
        $admin4->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin1);
        $manager->persist($admin2);
        $manager->persist($admin3);
        $manager->persist($admin4);

        #vendeurs
        $seller = new User();
        $seller->setEmail('seller@gmail.com');
        $seller->setFirstName('Seller');
        $seller->setLastName('User');
        $seller->setPassword($this->hasher->hashPassword($seller, 'agora'));
        $seller->setRoles(['ROLE_SELLER']);

        #clients
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $user->setPassword($this->hasher->hashPassword($user,'user'));
            $user->setFirstName('Client');
            $user->setLastName('User');
            $manager->persist($user);


        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['user'];
    }
}
