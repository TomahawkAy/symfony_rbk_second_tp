<?php

namespace App\Controller;

use App\Entity\Cagnotte;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cagnottes")
 */
class CagnotteController extends AbstractController
{
    /**
     * @Route("/", name="cagnotte_index")
     */
    public function index(): Response
    {
        $c = $this->getDoctrine()->getRepository(Cagnotte::class)->findAll();
        return $this->render('cagnotte/index.html.twig', [
            'cagnottes' => $c,
        ]);
    }
    /**
     * @Route("/create", name="cagnotte_create")
     */
    public function createCagnotte(){
        if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['target-amount']) && isset($_POST['deadline']) &&
        isset($_POST['user'])){
            $user = $this->getDoctrine()->getRepository(User::class)->find($_POST['user']);
            if ($user instanceof User){
                $cagnotte = new Cagnotte();
                $cagnotte->setCurrentAmount(0);
                $cagnotte->setCreationDate(new \DateTime('now'));
                $cagnotte->setTitle($_POST['name']);
                $cagnotte->setDeadline(new \DateTime($_POST['deadline']));
                $cagnotte->setTargetAmount($_POST['target-amount']);
                $cagnotte->setDescription($_POST['description']);
                $cagnotte->setUser($user);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($cagnotte);
                $manager->flush();
            }
            return $this->redirectToRoute('cagnotte_index');
        }
        else {
            return $this->render('cagnotte/new-cagnotte.html.twig');
        }
    }

    /**
     * @Route("/contribute/{id}", name="cagnotte_contribution")
     */
    public function contributeCagnotte($id){
        $manager = $this->getDoctrine()->getManager();
        $cagnotte = $this->getDoctrine()->getRepository(Cagnotte::class)->find($id);
        $currDate = new \DateTime('now');
        if ($cagnotte instanceof Cagnotte){
            if (isset($_POST['contribution'])){
                if ($cagnotte->getDeadline() > $currDate && $cagnotte->getCurrentAmount() < $cagnotte->getTargetAmount() ){
                    $cagnotte->setCurrentAmount($cagnotte->getCurrentAmount() + $_POST['contribution']);
                    $manager->flush();
                }
            }
        }
        return $this->redirectToRoute('cagnotte_index');
    }
}
