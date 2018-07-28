<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisteredEvent;
use App\Form\Signup;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SignUpController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $eventDispatcher, UserRepository $userRepository, LoggerInterface $logger2)
    {


        $user = new User();
        $form = $this->createForm(Signup::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
                $user = $form->getData();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //$logger->info('nouvel utilisateur !');
            $this->addFlash('notice','Nouveau utilisateur enregistré '.$user->getFirstname());
            $event = new UserRegisteredEvent($user);
            $eventDispatcher->dispatch(UserRegisteredEvent::NAME,$event);
            return $this->redirectToRoute('home');

        }

        return $this->render('signup/index.html.twig', array(
            'controller_name' => 'SignUpController',
            'form' => $form->createView(),
            )
        );
    }
}
