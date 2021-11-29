<?php

namespace App\Services\User;

use App\Repository\UserRepository;
use App\Entity\User;

use App\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     *  @var UserRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    // public function __construct(UserRepositoryInterface $userRepository, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handleCreate(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $this->userRepository->setCreate($user);

        return $this;
    }

    public function handleUpdate (User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $this->userRepository->setSave($user);
        return $this;
    }
}