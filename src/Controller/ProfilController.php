<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(CommandeRepository $repo)
    {

        $user = $this->getUser();

        if(!$user)
        {
            $this->addFlash("error", "Vous devez être connecter pour accéder à votre compte !");
            return $this->redirectToRoute('app_login');
        }

        $commandes = $repo->findBy(["vehicule" => $user]);

        return $this->render('profil/index.html.twig', [
            'commandes' => $commandes
        ]);
    }
}
