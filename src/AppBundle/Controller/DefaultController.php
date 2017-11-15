<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Budget;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $budgets = $this->getDoctrine()
            ->getRepository('AppBundle:Budget')
            ->findAll();


        return $this->render('default/index.html.twig', array(
            'budgets' => $budgets,
        ));
    }
}
