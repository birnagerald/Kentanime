<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminPostController extends AbstractController
{
    /**
     * @Route("/admin/post", name="admin_post_index")
     */
    public function index(PostRepository $repo)
    {

        $posts = $repo->findAll();
        return $this->render('admin/post/index.html.twig', compact('posts'));
    }

    /**
     * @route("/admin/post/new", name="admin_post_new")
     * @param Request $request
     * @param ObjectManager $em
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\Response
     */

    function new (Request $request, ObjectManager $em, Security $security) {
        $post = new Post;
        $user = $security->getUser();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setUser($user);
            $this->em = $em;
            $this->em->persist($post);

            $this->em->flush();
            $this->addFlash('success', 'Article créé avec succès');
            return $this->redirectToRoute('admin_post_index');
        }
        return $this->render('admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/post/edit/{id}", name="admin_post_edit", methods="GET|POST")
     * @param Post $post
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Post $post, Request $request, ObjectManager $em)
    {

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em = $em;
            $this->em->flush();
            $this->addFlash('success', 'Article édité avec succès');

        }
        return $this->render('admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/post/delete/{id}", name="admin_post_delete", methods="DELETE")
     * @param Post $post
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Post $post, Request $request, ObjectManager $em)
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->get('_token'))) {
            $this->em = $em;
            $this->em->remove($post);
            $this->em->flush();
            $this->addFlash('success', 'article supprimé avec succès');
        }

        return $this->redirectToRoute('admin_post_index');

    }

}
