<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandRepository")
 */
class Command
{
    public function __construct ()
    {
        $this->tickets = new ArrayCollection();
        $this->commandDate = new \DateTime();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="reservationCode", type="string", length=255, unique=true)
     */
    private $reservationCode;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="command", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tickets;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservationDate", type="date")
     */
    private $reservationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commandDate", type="datetime")
     */
    private $commandDate;

    /**
     * @return \DateTime
     */
    public function getCommandDate()
    {
        return $this->commandDate;
    }

    /**
     * @param \DateTime $commandDate
     */
    public function setCommandDate($commandDate)
    {
        $this->commandDate = $commandDate;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Command
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set reservationCode
     *
     * @param string $reservationCode
     *
     * @return Command
     */
    public function setReservationCode($reservationCode)
    {
        $this->reservationCode = $reservationCode;

        return $this;
    }

    /**
     * Get reservationCode
     *
     * @return string
     */
    public function getReservationCode()
    {
        return $this->reservationCode;
    }

    /**
     * Set reservationDate
     *
     * @param \DateTime $reservationDate
     *
     * @return Command
     */
    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    /**
     * Get reservationDate
     *
     * @return \DateTime
     */
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    public function addTickets(Ticket $ticket)
    {
        $this->tickets->add($ticket);
        $ticket->setCommand($this);
    }

    public function removeTickets(Ticket $ticket)
    {
        $this->tickets->remove($ticket);
    }

    public function getTickets()
    {
        return $this->tickets;
    }

    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }
}

