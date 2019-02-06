<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPageController extends AbstractController
{
    /**
     * @Route("/profil/{username}", name="user_profil")
     * @IsGranted("ROLE_USER")
     */
    public function userPage(Request $request, Security $security, UserRepository $repoUser)
    {
        $username = $request->attributes->get('username');

        $user = $repoUser->findOneBy(array('username' => $username));
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Utilisateur édité avec succès');

        }

        return $this->render('user/userPage.html.twig', [
            'user' => $user,
            'form' => $form->createView()

        ]);
    }



    /**
     * Reset Password 
     * 
     * @Route("/profil/{username}/resetPassword", name="user_reset_password")
     * @IsGranted("ROLE_USER")
     * 
     * @param Request $request
     * @return void
     */
    public function ResetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $request->request->get('reset_password')['oldPassword'];
            $newPassword = $request->request->get('reset_password')['password'];
            
            // if old password is correct
            if (password_verify($oldPassword, $user->getPassword())) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
                $user->setPassword($newEncodedPassword);

                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('user_profil', ['username' => $user->getUsername()]);
            } else {
                $form->addError(new FormError('Mot de passe actuel incorrect'));
            }
        }

        return $this->render('user/resetPassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}