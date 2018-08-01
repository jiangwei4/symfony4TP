<?php
namespace App\Event;

use App\Entity\Movie;
use Symfony\Component\EventDispatcher\Event;

class MovieRemovedEvent extends Event {
    const NAME = 'movie.removed';

    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie =$movie;
    }
    public function getMovie(): Movie{
        return $this->movie;
    }
}