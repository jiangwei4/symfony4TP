<?php
namespace App\Subscriber;

use App\Event\MovieRemovedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MovieRemoved implements EventSubscriberInterface {
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [MovieRemovedEvent::NAME=>'onMovieRemovedEvent'];
    }

    public function onMovieRemovedEvent(MovieRemovedEvent $movieRemovedEvent){
        $movie = $movieRemovedEvent->getMovie();
        $this->logger->info('suppression de la video ! title = '.$movie->getTitle().'  email = '.$movie->getUser()->getEmail());
    }
}