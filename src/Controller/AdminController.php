<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vehicule;
use App\Form\MembreFormType;
use App\Form\VehiculeFormType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/vehicules", name="admin_vehicules")
     * @Route("/admin/vehicules/edit/{id}", name="admin_edit_vehicule")
     */
    public function adminVehicules(VehiculeRepository $repo, Vehicule $vehicule = null, Request $superglobals, EntityManagerInterface $manager)
    {
        // On utilise le manager pour récupérer le nom des champs de la table Vehicule
        $champs = $manager->getClassMetadata(Vehicule::class)->getFieldNames();

        $vehicules = $repo->findAll();
        //dd($champs);
        if($vehicule == null)
        {
            $vehicule = new Vehicule;
            $vehicule->setDateEnregistrement(new \DateTime());
        }
        
        $form = $this->createForm(VehiculeFormType::class, $vehicule);
        $form->handleRequest($superglobals);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($vehicule);
            $manager->flush();
            return $this->redirectToRoute('admin_vehicules');
        }

        return $this->renderForm("admin/gestion_vehicules.html.twig", [
            'vehicules' => $vehicules,
            'champs' => $champs,
            'formVehicule' => $form,
            'editMode' => $vehicule->getId() !== NULL
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="admin_delete_vehicule")
     */
    public function vehiculeDelete($id, EntityManagerInterface $manager, VehiculeRepository $repo)
    {
        $vehicule = $repo->find($id);

        $manager->remove($vehicule);
        $manager->flush();

        $this->addFlash('success', "L'article a bien été supprimé !");

        return $this->redirectToRoute('admin_vehicules');
    } 

    /**
     * @Route("/admin/membres", name="admin_membres")
     * @Route("/admin/membres/edit/{id}", name="admin_edit_membre")
     */
    public function adminMembres(UserRepository $repo, User $user = null, Request $superglobals, EntityManagerInterface $manager)
    {
        // On utilise le manager pour récupérer le nom des champs de la table Vehicule
        $champs = $manager->getClassMetadata(User::class)->getFieldNames();
        
        $users = $repo->findAll();
        //dd($champs);
        if($user == null)
        {
            $user = new User;
            $user->setDateEnregistrement(new \DateTime());
        }
        
        $form = $this->createForm(MembreFormType::class, $user);
        $form->handleRequest($superglobals);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_membres');
        }
        
        return $this->renderForm("admin/gestion_membres.html.twig", [
            'membres' => $users,
            'champs' => $champs,
            'formMembre' => $form,
            'editMode' => $user->getId() !== NULL
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="admin_delete_membre")
     */
    public function membreDelete($id, EntityManagerInterface $manager, UserRepository $repo)
    {
        $membre = $repo->find($id);

        $manager->remove($membre);
        $manager->flush();

        $this->addFlash('success', "L'article a bien été supprimé !");

        return $this->redirectToRoute('admin_membres');
    } 
}


