<?php

namespace App\Controller\Dashboard;

use App\Entity\Anime;
use App\Form\AnimeType;
use App\Repository\AnimeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAnimeController extends AbstractController
{
    /**
     * @Route("/dashboard/anime", name="admin_anime_index")
     * @param AnimeRepository $repo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(AnimeRepository $repo, PaginatorInterface $paginator, Request $request) : Response
    {

        $animes = $paginator->paginate(
            $repo->createQuery(),

            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/anime/index.html.twig', [
            'animes' => $animes,
        ]);
    }

    /**
     * @route("/dashboard/anime/new", name="admin_anime_new")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */

    function new(Request $request, ObjectManager $em)
    {
        $anime = new Anime;
        $form = $this->createForm(AnimeType::class, $anime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em = $em;
            $this->em->persist($anime);
            $this->em->flush();
            $this->addFlash('success', 'Page créée avec succès');
            return $this->redirectToRoute('admin_anime_index');
        }
        return $this->render('admin/anime/new.html.twig', [
            'anime' => $anime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/anime/edit/{id}", name="admin_anime_edit", methods="GET|POST")
     * @param Anime $anime
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Anime $anime, Request $request, ObjectManager $em)
    {

        $form = $this->createForm(AnimeType::class, $anime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em = $em;
            $this->em->flush();
            $this->addFlash('success', 'Page éditée avec succès');

        }
        return $this->render('admin/anime/edit.html.twig', [
            'anime' => $anime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/anime/delete/{id}", name="admin_anime_delete", methods="DELETE")
     * @param Anime $anime
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Anime $anime, Request $request, ObjectManager $em)
    {
        if ($this->isCsrfTokenValid('delete' . $anime->getId(), $request->get('_token'))) {
            $this->em = $em;
            $this->em->remove($anime);
            $this->em->flush();
            $this->addFlash('success', 'Page supprimée avec succès');
        }

        return $this->redirectToRoute('admin_anime_index');

    }

}
