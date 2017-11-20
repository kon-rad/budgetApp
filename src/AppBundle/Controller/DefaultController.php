<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Budget;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="budget_list")
     */
    public function indexAction(Request $request)
    {

        $budgets = $this->getDoctrine()
            ->getRepository('AppBundle:Budget')
            ->findAll();


        return $this->render('budget/index.html.twig', array(
            'budgets' => $budgets,
        ));
    }

    /**
     * @Route("/budgets", name="get_budgets")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getBudgetsAction()
    {
        $budgets = $this->getDoctrine()
            ->getRepository('AppBundle:Budget')
            ->findAll();

        $budgets = array_map(function(Budget $budget) {
            return [
                "id" => $budget->getId(),
                "item" => $budget->getItem(),
                "category" => $budget->getCategory(),
                "amount" => $budget->getAmount(),
                "date" => $budget->getDate()
            ];
        }, $budgets);
        return new JsonResponse([
            "status" => "success",
            "budgets" => $budgets,
        ]);
    }

    /**
     * @Route("/budgets", name="add_item")
     * @Method({"POST"})
     *
     * @param Request $request
     * @param $budget
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $budget = new Budget;

        if(!empty($budget)) {
            $item = $request->request->get('item', '');
            $category = $request->request->get('category', '');
            $date = $request->request->get('date', '');
            $amount = $request->request->get('amount', '');

            $budget->setItem($item);
            $budget->setCategory($category);
            $budget->setDate($date);
            $budget->setAmount($amount);

            $em = $this->getDoctrine()->getManager();
            $em->persist($budget);
            $em->flush();

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Item added successfully'
            ]);

        }
        return new JsonResponse([
            'status' => 'error',
            'message' => 'No request body',
        ]);
    }

    /**
     * @Route("/budgets/{id}", name="budget_edit")
     *@Method({"PUT"})
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $budget = $em->getRepository('AppBundle:Budget')->find($id);

        $item = $request->request->get('item', '');
        $category = $request->request->get('category', '');
        $date = $request->request->get('date', '');
        $amount = $request->request->get('amount', '');

        $budget->setItem($item);
        $budget->setCategory($category);
        $budget->setAmount($amount);
        $budget->setDate($date);

        $em->flush();

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Item edited successfully'
        ]);
    }

    /**
     * @Route("/budgets/{id}", name="budget_delete")
     *@Method({"DELETE"})
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $budget = $this->getDoctrine()
            ->getRepository('AppBundle:Budget')
            ->findOneBy(array('id' => $id));

        $em->remove($budget);
        $em->flush();

        return $this->redirectToRoute('budget_list');
    }
}
