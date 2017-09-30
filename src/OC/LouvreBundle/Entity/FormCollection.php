<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FormCollection
 *
 * @ORM\Table(name="formCollection")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\FormCollectionRepository")
 */
class FormCollection
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="OC\LouvreBundle\Entity\Clients", cascade={"persist"})
     */
    protected $clients;

    /**
     * @ORM\OneToOne(targetEntity="OC\LouvreBundle\Entity\Billets", cascade={"persist"})
     */
    protected $billets;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        //$this->billets = new ArrayCollection();
    }

    public function addClients(Clients $client) {
        $client->addFormCollection($this);
        $this->clients->add($client);
    }

    public function addBillets(Billets $billet) {
        $billet->addFormCollection($this);
        $this->billets->add($billet);
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param mixed $clients
     */
    public function setClients(Clients $client)
    {
        $this->clients = $client;
    }

    /**
     * @return mixed
     */
    public function getBillets()
    {
        return $this->billets;
    }

    /**
     * @param mixed $billet
     */
    public function setBillets(Billets $billet)
    {
        $this->billets = $billet;
    }

}