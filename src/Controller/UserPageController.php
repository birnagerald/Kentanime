<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserPageController extends AbstractController
{
    /**
     * @Route("/profil", name="user_profile")
     * @IsGranted("ROLE_USER")
     */
    public function index(Security $security)
    {

        $user = $security->getUser();

        return $this->render('user/userPage.html.twig', [
            'user' => $user,

        ]);
    }

}