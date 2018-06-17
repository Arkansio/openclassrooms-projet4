<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 06/17/2018
 * Time: 03:53
 */

namespace AppBundle\Service;


class CalculPrice
{
    public function calculPriceTickets($ticketList) {
        $ticketsPriceList = [];
        foreach($ticketList as $ticket) {
            $ticketPrice = [$ticket];
            $birthday = $ticket->getBirth();
            $age = $this->calculAge($birthday);
            $price = 0;
            if($age >= 12 and $age < 60) {
                $price = 16;
            } else if($age >= 4 and $age < 12) {
                $price = 8;
            } else if($age >= 60) {
                $price = 12;
            }

            if($ticket->getReducePrice() and $age >= 12) {
                $price = 10;
            }
            array_push($ticketPrice, $price);
            array_push($ticketsPriceList, $ticketPrice);
        }
        return $ticketsPriceList;
    }
    private function calculAge($birthDate)
    {
        $age = date_diff($birthDate, new \DateTime('now'));
        return $age->format('%y');
    }
}