<?php
namespace App\Event;

use App\Entity\Movie;
use Symfony\Component\EventDispatcher\Event;

class MovieRegisteredEvent extends Event {
    const NAME = 'movie.registered';

    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie =$movie;
    }
    public function getMovie(): Movie{
        return $this->movie;
    }
}