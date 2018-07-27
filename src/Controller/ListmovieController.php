<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\EditmovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/listmovie/edite/{id}", name="listmovie_edite")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager,
                         MovieRepository $videoRepository, int $id)
    {

        $movie = $videoRepository->find($id);
        $form = $this->createForm(EditmovieType::class, $movie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($movie);
            $entityManager->flush();
            $this->addFlash('notice', 'Changement(s) effectué(s)!');

            return $this->redirectToRoute('listmovie');
        }

        return $this->render('listmovie/editMovie.html.twig', [
            'controller_name' => 'EditmovieController',
            'form' => $form->createView(),
        ]);
    }
}
