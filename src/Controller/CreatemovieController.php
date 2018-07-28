<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Event\MovieRegisteredEvent;
use App\Form\CreatevideoType;
use App\Repository\MovieRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CreatemovieController extends Controller
{
    /**
     * @Route("/createmovie", name="createmovie")
     */
    public function index(Request $request, MovieRepository $articleRepository)
    {
        $user = $this->getUser();
        $movie = new Movie();
        $form = $this->createForm(CreatevideoType::class,$movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $movie->setUrl(str_replace('watch?v=','embed/',$movie->getUrl()));
            $movie->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
            $this->addFlash('notice','vidéo crée');
            return $this->redirectToRoute('home');
        }

        return $this->render('createmovie/index.html.twig', [
            'controller_name' => 'CreatemovieController',
            'form' => $form->createView(),
        ]);
    }
}
