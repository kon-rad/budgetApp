<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Budget;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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


        return $this->render('budget/index.html.twig', array(
            'budgets' => $budgets,
        ));
    }

    /**
     * @Route("/budget/create", name="add_item")
     */
    public function createAction(Request $request)
    {
        $budget = new Budget;

        $form = $this->createFormBuilder($budget)
            ->add('item', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('amount', MoneyType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date', DateType::class, array('attr' => array('class' => 'formControl', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=>'Add Item', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $item = $form['item']->getData();
            $date = $form['date']->getData();
            $amount = $form['amount']->getData();

            $budget->setItem($item);
            $budget->setDate($date);
            $budget->setAmount($amount);

            $em = $this->getDoctrine()->getManager();
            $em->persist($budget);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }


        return $this->render('budget/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/budget/edit/{id}", name="budget_edit")
     */
    public function editAction(Request $request)
    {

        $id = $request->attributes->get('id');
        $budget = this->getDoctrine()->getRepositiory('AppBundle:Todo')->findOneBy(array('id' => $id));

        $budget->set


        return $this->render('budget/edit.html.twig', array(
            'id' => $id,
        ));
    }
}
