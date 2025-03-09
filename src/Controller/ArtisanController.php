<?php

// src/Controller/ArtisanController.php
namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface; 
use App\Entity\Artisan;
use App\Form\ArtisanType;
use App\Repository\ArtisanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ArtisanController extends AbstractController
{
    private $artisanRepository;
    private $entityManager;

    public function __construct(ArtisanRepository $artisanRepository, EntityManagerInterface $entityManager)
    {
        $this->artisanRepository = $artisanRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/artisans', name: 'admin_artisan_list')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $fullName = $request->query->get('fullName');
        $query = $this->artisanRepository->findAllQuery(); // Utilisez la méthode de récupération des artisans

        // Appliquer le filtre sur fullName si présent
        if ($fullName) {
            $query = $this->artisanRepository->findByFullNameQuery($fullName); // Méthode à ajouter dans ArtisanRepository
        }

        // Pagination des résultats
        $artisans = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de la page courante
            10 // Limite par page
        );

        return $this->render('artisan/index.html.twig', [
            'artisans' => $artisans,
        ]);
    }


    #[Route('/admin/artisans/create', name: 'artisan_create')]
    public function create(Request $request): Response
    {
        $artisan = new Artisan();
        $form = $this->createForm(ArtisanType::class, $artisan);
    
        $form->handleRequest($request);
    
        // Si le formulaire est soumis mais contient des erreurs, elles seront disponibles dans la vue.
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($artisan);
            $this->entityManager->flush();
    
            return $this->redirectToRoute('admin_artisan_list');
        }
    
        return $this->render('artisan/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/artisans/{id}/edit', name: 'artisan_edit')]
    public function edit(Request $request, Artisan $artisan): Response
    {
        $form = $this->createForm(ArtisanType::class, $artisan);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
    
            return $this->redirectToRoute('admin_artisan_list');
        }
    
        return $this->render('artisan/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/artisans/{id}/delete', name: 'artisan_delete')]
    public function delete(Request $request, Artisan $artisan): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artisan->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($artisan);
            $this->entityManager->flush();
        }
    
        return $this->redirectToRoute('admin_artisan_list');
    }
    
}
