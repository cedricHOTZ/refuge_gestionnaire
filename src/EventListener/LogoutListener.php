<?php
 
namespace App\EventListener;
 
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
 
class LogoutListener 

{
    private $FlashBagInterface;
 
    public function __construct(SessionInterface $session)
    {
        $this->flashBag = $session->getFlashBag();
    }
 
    public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent $event): void
    {
        $this->flashBag->add('success', 'Vous êtes déconnecté');
        /*
        If you need user...
        if (($token = $event->getToken()) && $user = $token->getUser()) {
            $user available
        }
        */
    }
}