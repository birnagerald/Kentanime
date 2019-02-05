<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

}