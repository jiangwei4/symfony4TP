<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Form\EdituserType;
use App\Repository\UserRepository;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class ListusersController extends Controller
{
    /**
     * @Route("/listusers", name="listusers")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        $u = array();
        foreach ($users as $user){
            if($user != $this->getUser()){
                array_push($u,$user);
            }
        }
        return $this->render('listusers/index.html.twig', [
            'controller_name' => 'ListusersController',
            'users' => $u,
        ]);
    }

    /**
     * @Route("/listuser/remove/{id}", name="listuser_remove")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function remove(User $user, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('listusers');

    }


    /**
     * @Route("/listuser/edit/{id}", name="listuser_edit")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager,
                         UserRepository $userRepository, int $id)
    {

        $user = $userRepository->find($id);
        $form =$this->createForm(EdituserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', 'Changement(s) effectué(s)!');
            return $this->redirectToRoute('listusers');
        }

        return $this->render('listusers/editindex.html.twig', [
            'controller_name' => 'EdituserController',
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/listuser/listmovie/{id}", name="listuser_listmovie")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function listMovie(User $user, EntityManagerInterface $entityManager, UserRepository $userRepository, int $id, MovieRepository $movieRepository)
    {
        $user = $userRepository->find($id);
        $movies = $movieRepository->findBy(['user'=>$user]);
        return $this->render('listusers/listmovieindex.html.twig', [
            'controller_name' => 'listuserlistmovieController',
            'movies' => $movies,
        ]);

    }

    /**
     * @Route("/listuser/movieremove/{id}", name="listuser_movieremove")
     * @ParamConverter("movie", options={"mapping"={"id"="id"}})
     */
    public function removeMovie(Movie $movie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($movie);
        $entityManager->flush();
        return $this->redirectToRoute('listuser_listmovie', ['id' => $movie->getUser()->getId()]);

    }




}
