<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        
        return $this->render('admin/board/index.html.twig');

    }
}
