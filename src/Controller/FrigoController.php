<?php

namespace App\Controller;

use App\Entity\Frigo;
use App\Form\FrigoType;
use App\Repository\FrigoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/frigo',name: "frigo")]
final class FrigoController extends AbstractController
{
    #[Route(name: 'app_frigo_index', methods: ['GET'])]
    public function index(FrigoRepository $frigoRepository): Response
    {
        return $this->render('frigo/index.html.twig', [
            'frigos' => $frigoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_frigo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $frigo = new Frigo();
        $form = $this->createForm(FrigoType::class, $frigo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($frigo);
            $entityManager->flush();

            return $this->redirectToRoute('app_frigo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frigo/new.html.twig', [
            'frigo' => $frigo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frigo_show', methods: ['GET'])]
    public function show(Frigo $frigo): Response
    {
        return $this->render('frigo/show.html.twig', [
            'frigo' => $frigo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_frigo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Frigo $frigo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FrigoType::class, $frigo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_frigo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frigo/edit.html.twig', [
            'frigo' => $frigo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frigo_delete', methods: ['POST'])]
    public function delete(Request $request, Frigo $frigo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$frigo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($frigo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_frigo_index', [], Response::HTTP_SEE_OTHER);
    }
}
