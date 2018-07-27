<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ListmovieController extends Controller
{
    /**
     * @Route("/listmovie", name="listmovie")
     */
    public function index(MovieRepository $movieRepository)
    {
        $user = $this->getUser();
        //$movie = $movieRepository->findBy(['user_id'=>$user->getId()], ['title'=>'ASC']);
        $movies = $movieRepository->findBy(['user'=>$user]);

        return $this->render('listmovie/index.html.twig', [
            'controller_name' => 'ListmovieController',
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/listmovie/remove/{id}", name="listmovie_remove")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function remove(Movie $movie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($movie);
        $entityManager->flush();
        return $this->redirectToRoute('listmovie');

    }

}
