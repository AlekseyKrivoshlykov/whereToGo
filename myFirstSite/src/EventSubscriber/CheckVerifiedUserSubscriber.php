<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
        ];
    }

    public function onCheckPassport(CheckPassportEvent $event)
    {
        $passport = $event->getPassport();
        if (!$passport instanceof UserPassportInterface) {
            throw new Exception('Неожиданный тип паспорта.');
        }

        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new Exception('Неожиданный тип пользователя');
        }

        if (!$user->isVerified()) {
            throw new CustomUserMessageAuthenticationException(
                'Пожалуйста, пройдите верификацию через Вашу почту (пройдя по ссылке в письме).'
            );

        }
    }
}

    