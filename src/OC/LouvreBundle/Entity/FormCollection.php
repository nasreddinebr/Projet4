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


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add client
     *
     * @param \OC\LouvreBundle\Entity\Clients $client
     *
     * @return FormCollection
     */
    public function addClient(\OC\LouvreBundle\Entity\Clients $client)
    {
        $this->clients[] = $client;


        return $this;
    }

    /**
     * Remove client
     *
     * @param \OC\LouvreBundle\Entity\Clients $client
     */
    public function removeClient(\OC\LouvreBundle\Entity\Clients $client)
    {
        $this->clients->removeElement($client);
    }


    /**
     * Get clients
     *
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Set billets
     *
     * @param \OC\LouvreBundle\Entity\Billets $billets
     *
     * @return FormCollection
     */
    public function setBillets(\OC\LouvreBundle\Entity\Billets $billets = null)
    {
        $this->billets = $billets;

        return $this;
    }

    /**
     * Get billets
     *
     * @return \OC\LouvreBundle\Entity\Billets
     */
    public function getBillets()
    {
        return $this->billets;
    }
}
