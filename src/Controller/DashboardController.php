<?php
namespace App\Controller;

use App\Repository\ArtisanRepository;
use App\Repository\ProfileRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(ArtisanRepository $artisanRepository, ProfileRepository $profileRepository, ReservationRepository $reservationRepository)
    {
        $artisans = $artisanRepository->findAll();
        $profiles = $profileRepository->findAll();
        $reservations = $reservationRepository->findAll();

        // Calcul des données pour le graphique
        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        $maxProfiles = 0;

        foreach ($artisans as $artisan) {
            $chartData['labels'][] = $artisan->getFullName();
            $profileCount = count($artisan->getProfiles());
            $chartData['data'][] = $profileCount;

            if ($profileCount > $maxProfiles) {
                $maxProfiles = $profileCount;
            }
        }

        // Calcul des statistiques supplémentaires
        $totalArtisans = count($artisans);
        $totalProfiles = count($profiles);
        $totalReservations = count($reservations);

        return $this->render('dashboard/index.html.twig', [
            'chartData' => $chartData,
            'maxProfiles' => $maxProfiles,
            'totalArtisans' => $totalArtisans,
            'totalProfiles' => $totalProfiles,
            'totalReservations' => $totalReservations,
        ]);
    }
}
