<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SignUpController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     */
    public function index(Request $request, UserRepository $userRepository)
    {


        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignUpController',
            'form' => $form,
        ]);
    }
}
