<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\ContestEntry;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ContestOptionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\ContestQuestionRepository;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    private $generalConfigurationRepository;
    private $contestOptionRepository;
    private $contestQuestionRepository;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        GeneralConfigurationRepository $generalConfigurationRepository,
        ContestOptionRepository $contestOptionRepository,
        ContestQuestionRepository $contestQuestionRepository
    ) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->generalConfigurationRepository = $generalConfigurationRepository;
        $this->contestOptionRepository = $contestOptionRepository;
        $this->contestQuestionRepository = $contestQuestionRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        for ($i = 0; $i < 100; $i++) {
            $firstname = $faker->firstName;
            $lastname = $faker->lastName;
            $email = $faker->email;
            $telephone = $faker->phoneNumber;

            $contestOption1 = new ContestEntry();
            $contestOption1
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setTelephone($telephone)
                ->setContestOption($this->contestOptionRepository->findById(mt_rand(1, 2)))
                ->setContestQuestion($this->contestQuestionRepository->findById(1))
            ;
            $manager->persist($contestOption1);

            $contestOption2 = new ContestEntry();
            $contestOption2
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setTelephone($telephone)
                ->setContestOption($this->contestOptionRepository->findById(mt_rand(3, 5)))
                ->setContestQuestion($this->contestQuestionRepository->findById(2))
            ;
            $manager->persist($contestOption2);
        }


        $manager->flush();
    }
}
