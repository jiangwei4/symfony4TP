<?php
namespace App\Subscriber;

use App\Event\UserRemoverEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRemover implements EventSubscriberInterface {
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [UserRemoverEvent::NAME=>'onUserRemoverEvent'];
    }

    public function onUserRemoverEvent(UserRemoverEvent $userRemoverEvent){
        $user = $userRemoverEvent->getUser();
        $this->logger->info('suppression de utilisateur ! id = '.$user->getId().'  email = '.$user->getEmail());
    }
}