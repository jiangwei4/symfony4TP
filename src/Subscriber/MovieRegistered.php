<?php
namespace App\Subscriber;

use App\Event\MovieRegisteredEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MovieRegistered implements EventSubscriberInterface {
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [MovieRegisteredEvent::NAME=>'onMovieRegisteredEvent'];
    }

    public function onMovieRegisteredEvent(MovieRegisteredEvent $movieRegisteredEvent){
        $movie = $movieRegisteredEvent->getMovie();
        $this->logger->info('creation de la video ! title = '.$movie->getTitle().'  email = '.$movie->getUser()->getEmail());
    }
}