<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
  public $encoder;
  public $users;

  public function __construct(UserPasswordEncoderInterface $encoder)
  {
      $this->encoder = $encoder;
      $this->users = [
          [
              "username" => "Administrateur",
              "password" => "admin",
              "roles" => ["ROLE_ADMIN"]
          ],[
              "username" => "Trickstar101",
              "password" => "MotDePasseSuperSolide",
              "roles" => ["ROLE_USER"]
          ]
      ];
  }

  public function load(ObjectManager $manager)
  {
    //Création des utilisateurs
    foreach ($this->users as $index => $userData)
    {
      $user = new User();
      $user->setUsername($userData["username"]);
      $password = $this->encoder->encodePassword($user, $userData["password"]);
      $user->setPassword($password);
      $user->setRoles($userData["roles"]);
      $this->addReference("User-".$index, $user);

      $manager->persist($user);
    }
    $manager->flush();
  }
}