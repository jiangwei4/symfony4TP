<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SigninType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SigninController extends Controller
{
    /**
     * @Route("/signin", name="signin")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $user = new User();
        $form= $this->createForm(SigninType::class, $user);

        return $this->render('signin/index.html.twig', [
            'controller_name' => 'SigninController',
            'form'=> $form->createView(),
        ]);
    }
}
