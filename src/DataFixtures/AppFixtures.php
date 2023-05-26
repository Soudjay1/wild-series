<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Category array

        $categories = [];

        for ($i = 0; $i < 6; $i++) {
            $category = new Category();
            $category
                ->setName($faker->name());

            $manager->persist($category);

            $categories[] = $category;
        }

        for ($i = 0; $i < 6; $i++) {
            $program = new Program();
            $program
                ->setTitle($faker->title())
                ->setSynopsis($faker->sentence())
                ->setCategory($categories[rand(0, count($categories) - 1)]);

            $manager->persist($program);
        }

        $manager->flush();
    }
}
