<?php
namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRemoverEvent extends Event {
    const NAME = 'user.remover';

    protected $user;

    public function __construct(User $user)
    {
        $this->user =$user;
    }
    public function getUser(): User{
        return $this->user;
    }
}