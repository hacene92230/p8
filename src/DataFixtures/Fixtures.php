<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Fixtures extends Fixture
{
    private $hash;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->hash = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // création des utilisateurs 
        $users = [];
        $owners = [];
        for ($u = 0; $u <= 30; $u++) {
            $user = new User();
            $user->setUserName("user" . $u)
                ->setEmail("email" . $u . "@gmail.com");
            if ($u == 0) {
                $user->setRoles(["ROLE_ADMIN"]);
            } else {
                $user->setRoles(["ROLE_USER"]);
            }
            $user->setPassword($this->hash->hashPassword($user, 'password'));
            $manager->persist($user);
            $users[] = $user;
        }

        // création des tâches
        for ($t = 0; $t <= 50; $t++) {
            $task = new Task();
            $task->setCreatedAt(new DateTimeImmutable())
                ->setIsDone(rand(0, 1))
                ->setTitle("titre" .  $t)
                ->setContent("contenu pour la tâche" . $t)
                ->setUser($users[array_rand($users)]);
            $manager->persist($task);
            $tasks[] = $task;
        }

        $manager->flush();
    }
}
