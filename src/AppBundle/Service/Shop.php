<?php
/**
 * Created by PhpStorm.
 * User: arkansio
 * Date: 24/06/2018
 * Time: 13:13
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Session\Session;

class Shop
{
    public function checkout(Session $session, CalculPrice $calculPrice) {

        $tickets = $session->get('ticketsShop');
        $total = $calculPrice->calculTotalPrice($tickets);


        \Stripe\Stripe::setApiKey("sk_test_mBmbXQUaRUiGHwXTEYj8TQJn");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $total, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            return true;
        } catch(\Stripe\Error\Card $e) {
            return false;
        }
    }
}