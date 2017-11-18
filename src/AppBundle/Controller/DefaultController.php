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
     * @Route("/", name="budget_list")
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

            $this->addFlash(
                'notice',
                'Item Added'
            );

            return $this->redirectToRoute('budget_list');
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
        $budget = $this->getDoctrine()
            ->getRepository('AppBundle:Budget')
            ->findOneBy(array('id' => $id));

        $budget->setItem($budget->getItem());
        $budget->setAmount($budget->getAmount());
        $budget->setDate($budget->getDate());

        $form = $this->createFormBuilder($budget)
            ->add('item', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('amount', MoneyType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date', DateType::class, array('attr' => array('class' => 'formControl', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=>'Edit Item', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $budget = $em->getRepository('AppBundle:Budget')->find($id);
            $budget->setItem($form['item']->getData());
            $budget->setAmount($form['amount']->getData());
            $budget->setDate($form['date']->getData());

            $em->flush();

            $this->addFlash(
                'notice',
                'Item Edited'
            );

            return $this->redirectToRoute('budget_list');
        }

        return $this->render('budget/edit.html.twig', array(
            'budget' => $budget,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/budget/delete/{id}", name="budget_delete")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $budget = $this->getDoctrine()
            ->getRepository('AppBundle:Budget')
            ->findOneBy(array('id' => $id));

        $em->remove($budget);
        $em->flush();

        $this->addFlash(
            'notice',
            'Item Removed'
        );

        return $this->redirectToRoute('budget_list');
    }
}
