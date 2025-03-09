<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Entity\Profile;
use App\Form\ProfileType;
use App\Entity\Reservation;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile_index')]
    public function index(Request $request, ProfileRepository $profileRepository, PaginatorInterface $paginator): Response
    {
        $specialite = $request->query->get('specialite');

        $query = $profileRepository->createQueryBuilder('p');

        if ($specialite) {
            $query->andWhere('p.specialite = :specialite')
                  ->setParameter('specialite', $specialite);
        }

        $profiles = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('profile/index.html.twig', [
            'profiles' => $profiles,
        ]);
    }

    #[Route('/profile/create', name: 'profile_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $profile = new Profile();
        $artisans = $em->getRepository(Artisan::class)->findAll();

        $form = $this->createForm(ProfileType::class, $profile, [
            'artisans' => $artisans,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $profile->setImage($newFilename);
            }

            $em->persist($profile);
            $em->flush();

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'profile_edit')]
    public function edit(Profile $profile, Request $request, EntityManagerInterface $em): Response
    {
        $artisans = $em->getRepository(Artisan::class)->findAll();

        $form = $this->createForm(ProfileType::class, $profile, [
            'artisans' => $artisans,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                if ($profile->getImage()) {
                    $oldImagePath = $this->getParameter('images_directory') . '/' . $profile->getImage();
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $profile->setImage($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'profile' => $profile,
        ]);
    }

    #[Route('/profile/{id}/delete', name: 'profile_delete', methods: ['POST', 'DELETE'])]
    public function delete(Profile $profile, EntityManagerInterface $em): Response
    {
        $reservations = $em->getRepository(Reservation::class)->findBy(['profile' => $profile]);

        foreach ($reservations as $reservation) {
            $em->remove($reservation);
        }

        if ($profile->getImage()) {
            $imagePath = $this->getParameter('images_directory') . '/' . $profile->getImage();
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $em->remove($profile);
        $em->flush();

        return $this->redirectToRoute('profile_index');
    }

    #[Route('/profile/{id}/like', name: 'profile_like', methods: ['POST'])]
    public function likeProfile(Profile $profile, EntityManagerInterface $em): JsonResponse
    {
        $profile->setLikes($profile->getLikes() + 1); // Incrémente les "likes"
        $em->flush(); // Sauvegarde dans la base
    
        return new JsonResponse(['likes' => $profile->getLikes()]);
    }
    
    #[Route('/profile/{id}/dislike', name: 'profile_dislike', methods: ['POST'])]
    public function dislikeProfile(Profile $profile, EntityManagerInterface $em): JsonResponse
    {
        $profile->setDislikes($profile->getDislikes() + 1); // Incrémente les "dislikes"
        $em->flush(); // Sauvegarde dans la base
    
        return new JsonResponse(['dislikes' => $profile->getDislikes()]);
    }
    
}
