<?php

namespace App\Command;

use App\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppCountMovieUserCommand extends Command
{
    protected static $defaultName = 'app:count-movie-user';
    private $UserManagement;

    public function __construct(UserManager $userManager)
    {
        $this->UserManagement = $userManager;
        parent::__construct();

    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('email');
        $user = $this->UserManagement->getUserByEmail($arg1);
        if ($user != null) {
            $count = $this->UserManagement->getNumberMoviesByUserEmail($arg1);
            $io->success(sprintf('l utilisateur %s a redigé %s articles',$user->getEmail() ,$count));
        } else {
            $io->error('No user with that email');
        }
    }
}


