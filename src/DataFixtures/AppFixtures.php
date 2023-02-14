<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
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
        // Create 10 entries for Hotel Entity
        for ($i=0; $i < 10; $i++) { 
            $hotel = new Hotel();
            $hotel
                ->setName($this->faker->name())
                ->setAdress($this->faker->address() )
                ->setStartRating($this->faker->numberBetween(0,5))
                ->setDescription($this->faker->paragraph())
                ;

            $manager->persist($hotel);
        }
        $manager->flush();
    }
}
