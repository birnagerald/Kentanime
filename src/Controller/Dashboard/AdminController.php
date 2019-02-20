<?php

namespace App\Controller\Dashboard;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {

        return $this->render('admin/board/index.html.twig');

    }
}
