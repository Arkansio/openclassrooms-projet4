<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Command;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CommandType;
use AppBundle\Service\Shop;
use Doctrine\DBAL\Types\BooleanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\CalculPrice;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index_website.html.twig');
    }

    /**
     * @Route("/billetterie/buy", name="billetterie")
     */
    public function billetterie(Request $request, CalculPrice $calculPrice)
    {
        $session = $request->getSession();
        $form = $this->CreateForm(CommandType::class);
        $form->handleRequest($request);
        $form->isSubmitted();
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $form->getData();
            dump($booking);

            $ticketList = $booking->getTickets();

            $ticketsPriceList = $calculPrice->calculPriceTickets($ticketList);

            $session->set('ticketsShop', $ticketsPriceList);
            print_r($session->get('ticketsShop'));

            /*
            $entityManager->persist($booking);
            $entityManager->flush();
            */

            return $this->redirectToRoute("payement");
        }
        else {
            return $this->render('default/billetterie.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @Route("/billetterie/payement", name="payement")
     */
    public function payement(Request $request, CalculPrice $calculPrice)
    {
        $session = $request->getSession();
        $tickets = $session->get('ticketsShop');
        $total = $calculPrice->calculTotalPrice($tickets);
        // replace this example code with whatever you need
        return $this->render('default/payement.html.twig', array(
            'tickets' => $tickets,
            'total' => $total
        ));
    }

    /**
     * @Route("/billetterie/thanks", name="thanks")
     */
    public function thanks(Request $request)
    {
        return $this->render('default/thanks.html.twig');
    }

    /**
     * @Route("/billetterie/checkout", name="checkout", methods="POST")
     */
    public function checkout(Request $request, Shop $shop, CalculPrice $calculPrice)
    {
        $session = $request->getSession();
        if($shop->checkout($session, $calculPrice)) {

        } else {

        }
        return $this->redirectToRoute("thanks");
    }
}
