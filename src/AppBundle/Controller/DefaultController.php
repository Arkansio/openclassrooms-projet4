<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Command;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CommandType;
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
    public function billetterie(Request $request)
    {
        $form = $this->CreateForm(CommandType::class);
        $form->handleRequest($request);
        $form->isSubmitted();
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $form->getData();
            dump($booking);

            $reservationCode = sha1(random_bytes(50));
            $booking->setReservationCode($reservationCode);
            $ticketList = $booking->getTickets();
            foreach($ticketList as $ticket) {
                $ticket->setCommand($booking);
            }

            $calculPrice = $this->get(CalculPrice::class);
            $ticketsPriceList = $calculPrice->calculPriceTickets($ticketList);

            print_r($ticketsPriceList);
            $entityManager->persist($booking);
            $entityManager->flush();
        }
        return $this->render('default/billetterie.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
