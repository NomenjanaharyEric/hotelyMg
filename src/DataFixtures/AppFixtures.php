<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Room;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;


class AppFixtures extends Fixture
{
    /**
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {

        $users = [];
        // Create 5 User
        for ($i=0; $i < 5 ; $i++) { 
            $user = new User();
            $user
                ->setFullname($this->faker->name())
                ->setPseudo(mt_rand(0,1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword("password")
                ;
            $users[] = $user;
            $manager->persist($user);
        }

        // Create 10 entries for Hotel Entity
        for ($i=0; $i < 10; $i++) { 
            $hotel = new Hotel();
            $hotel
                ->setName($this->faker->name())
                ->setAdress($this->faker->address() )
                ->setNbStar($this->faker->numberBetween(0,5))
                ->setDescription($this->faker->text(150))
                ->setUser($users[mt_rand(0, count($users) -1)])
                ;

            

                // Create 3 to 8 Room for each Hotel
                for ($j=0; $j < mt_rand(3,8) ; $j++) { 
                    $room = new Room();
                    $room
                        ->setNumber($this->faker->randomNumber(3))
                        ->setName($this->faker->name())
                        ->setSize($this->faker->numberBetween(20, 200))
                        ->setLocation($this->faker->randomLetter() . ' - ' . $this->faker->address())
                        ->setCapacity($this->faker->numberBetween(0,250))
                        ->setPrice($this->faker->numberBetween(10000, 1000000))
                        ->setDescription($this->faker->text(60));
                    
                        $hotel->addRoom($room);

                    $manager->persist($room);
                }

            $manager->persist($hotel);
        }

        $manager->flush();
    }
}
