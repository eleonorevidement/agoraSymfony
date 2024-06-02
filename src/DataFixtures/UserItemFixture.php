<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// php bin/console doctrine:fixture:load

class UserItemFixture extends Fixture
{
    public function __construct(

        private UserPasswordHasherInterface $hasher
    ){}
    public function load(ObjectManager $manager): void
    {
        #admins
        $data = [
            [
                'email' => 'eleonore.vidementdupouy@edu.ece.fr',
                'firstName' => 'Eleonore',
                'lastName' => 'Videment',
                'password' => 'agora',
                'photo' => 'eleonore.jpg'
            ],
            [
                'email' => 'cedric.gourhant@edu.ece.fr',
                'firstName' => 'Cedric',
                'lastName' => 'Gourhant',
                'password' => 'agora',
                'photo' => 'cedric.jpg'
            ],
            [
                'email' => 'luna.rondineau@edu.ece.fr',
                'firstName' => 'Luna',
                'lastName' => 'Rondineau',
                'password' => 'agora',
                'photo' => 'luna.jpg'
            ],
            [
                'email' => 'halima.ghazi@edu.ece.fr',
                'firstName' => 'Halima',
                'lastName' => 'Ghazi',
                'password' => 'agora',
                'photo' => 'halima.jpg'
            ]
        ];

        foreach ($data as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);
            $user->setPassword($this->hasher->hashPassword($user, $userData['password']));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setProfilePicture($userData['photo']);
            $manager->persist($user);
        }



        #clients
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $user->setPassword($this->hasher->hashPassword($user,'user'));
            $user->setFirstName('Client');
            $user->setLastName('User');
            $manager->persist($user);


        }

        #seller
        for ($i = 0; $i < 3; $i++) {
            $seller = new User();
            $seller->setEmail("seller$i@gmail.com");
            $seller->setPassword($this->hasher->hashPassword($seller,'seller'));
            $seller->setFirstName('Seller');
            $seller->setLastName('SELLER');
            $seller->setRoles(['ROLE_SELLER']);
            $manager->persist($seller);

        }

        $manager->flush();

        $data = [
            ['name' => 'Chaise de bureau', 'description' => 'Chaise de bureau inclinable en cuir', 'price' => 140, 'category' => 1, 'photo' => 'chaise.jpg', 'seller' => 'seller0@gmail.com'],
            ['name' => 'Bureau luxe', 'description' => "Bureau en bois d'acajou massif", 'price' => 1200, 'category' => 2, 'photo' => 'bureau.jpg', 'seller' => 'seller0@gmail.com'],
            ['name' => 'Affiche déco', 'description' => 'Affiche décoration echelle de scoville', 'price' => 20, 'category' => 1, 'photo' => 'affiche.jpg', 'seller' => 'seller1@gmail.com'],
            ['name' => 'Néon déco', 'description' => 'Applique néon murale', 'price' => 90, 'category' => 1, 'photo' => 'neon.jpg', 'seller' => 'seller1@gmail.com'],
            ['name' => "Boucle d'oreilles Vivienne Westwood", 'description' => 'Petit modèle en or', 'price' => 180, 'category' => 2, 'photo' => 'boucles.jpg', 'seller' => 'seller2@gmail.com'],
        ];

        foreach ($data as $itemData) {
            $item = new Item();
            $item->setName($itemData['name']);
            $item->setDescription($itemData['description']);
            $item->setPrice($itemData['price']);
            $item->setCategory($itemData['category']);
            $item->setPhoto($itemData['photo']);
            $seller = $manager->getRepository(User::class)->findOneBy(['email' => $itemData['seller']]);
            $item->setSeller($seller);
            $manager->persist($item);
        }

        $manager->flush();
    }
}
