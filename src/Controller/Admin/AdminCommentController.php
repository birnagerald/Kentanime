<?php
namespace App;

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Comment $comment
     * @param ObjectManager $em
     * @return Response
     */
    public function edit(Request $request, Comment $comment, ObjectManager $em) : Response
    {

    }




}