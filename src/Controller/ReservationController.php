<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use App\Entity\Artisan;
use App\Entity\Profile;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;

#[Route('/')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'reservation_home', methods: ['GET'])]
    public function showProfiles(EntityManagerInterface $em): Response
    {
        $artisans = $em->getRepository(Artisan::class)->findAll();
        return $this->render('reservation/index.html.twig', [
            'artisans' => $artisans,
        ]);
    }

    #[Route('/reservation/{profile}', name: 'reservation_form', methods: ['GET', 'POST'])]
    public function makeReservation(Profile $profile, Request $request, EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();
        $reservation->setProfile($profile);
        $reservation->setArtisan($profile->getArtisan());

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'Réservation enregistrée avec succès.');
            return $this->redirectToRoute('profile_index');
        }

        return $this->render('reservation/form.html.twig', [
            'form' => $form->createView(),
            'profile' => $profile,
        ]);
    }

    #[Route('/profile/{id}', name: 'profile_show', methods: ['GET'])]
    public function showProfile(Profile $profile, EntityManagerInterface $em): Response
    {
        $existingReservation = $em->getRepository(Reservation::class)->findOneBy([
            'profile' => $profile,
            'status' => 'en traitement',
        ]);

        if (!$existingReservation) {
            $reservation = new Reservation();
            $reservation->setProfile($profile);
            $reservation->setArtisan($profile->getArtisan());
            $reservation->setStatus('en traitement');
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'Une réservation a été créée et est en cours de traitement.');
        } else {
            $this->addFlash('info', 'Une réservation est déjà en cours de traitement pour ce profil.');
        }

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    #[Route('/reservations', name: 'reservation_list', methods: ['GET'])]
    public function listReservations(Request $request, ReservationRepository $reservationRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $reservations = $reservationRepository->findPaginated($page, 10);

        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reservation/update/{id}', name: 'reservation_update', methods: ['POST'])]
    public function updateStatus(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        $newStatus = $request->request->get('status');
        if ($newStatus) {
            $reservation->setStatus($newStatus);
            $em->flush();
            $this->addFlash('success', 'Statut mis à jour avec succès.');
        } else {
            $this->addFlash('error', 'Statut invalide.');
        }

        return $this->redirectToRoute('reservation_list');
    }
}
