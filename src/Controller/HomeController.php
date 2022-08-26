<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
   
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    
    /**
     * @Route("/vehicules", name="app_vehicules")
     */
    public function index(VehiculeRepository $repo): Response
    {
        
        $vehicules = $repo->findAll();

        return $this->render('home/vehicules.html.twig', [
            'tabVehicules' => $vehicules  
        ]);

    }

     /**
     * @Route("/vehicules/commande/{id}", name="commande_vehicule")
     */
    public function show($id, VehiculeRepository $repo): Response
    {
        $vehicule =  $repo->find($id);

        return $this->render('home/commande.html.twig', [
            'commandeVehicule' => $vehicule
        ]);
    }
}
