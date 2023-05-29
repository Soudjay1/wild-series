<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\SeasonNumber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Category array

        $categories = ['Action','drame','horreur','fantastique','manga'];
        $categoryEntities = [];

        foreach ($categories as $categoryName){
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categoryEntities[] = $category;

        }


        // Program

        $programs = [];
         $categoryEntities[] = $category;
        for ($i = 0; $i < 20; $i++) {
            $program = new Program();
            $program
                ->setTitle($faker->sentence($nbWords = 10, $variableNbWords = true))
                ->setSynopsis($faker->sentence($nbWords = 150, $variableNbWords = true))
                ->setCategory($categoryEntities[rand(0, count($categoryEntities) - 1)]);

            $manager->persist($program);
            $programs[] = $program;
        }

        // SeasonNumber

        $seasonNumbers = [];
        for ($i = 0; $i < 3; $i++) {
            $seasonNumber = new SeasonNumber();
            $seasonNumber
                ->setNumber($faker->numberBetween($min = 1, $max = 3))
                ->setYear($faker->numberBetween($min = 2000, $max = 2020))
                ->setDescription($faker->sentence($nbWords = 10,$variableNbWords = true))
                ->setProgram($programs[rand(0, count($programs) - 1)]);

            $manager->persist($seasonNumber);
            $seasonNumbers[] = $seasonNumber;

    }
        // Episode

        for ($i = 0; $i < 10; $i++) {
            $episode = new Episode();
            $episode
                ->setEpisodeTitle($faker->title)
                ->setEpisodeNumber($faker->numberBetween($min = 1, $max = 5))
                ->setEpisodeSynopsis($faker->sentence($nbWords = 80, $variableNbWords = true))
                ->setSeason($seasonNumbers[rand(0,count($seasonNumbers) - 1)]);

            $manager->persist($episode);
        }
        $manager->flush();
}
}
