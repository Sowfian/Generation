<?php

namespace UserBundle\Entity;

/**
 * Groupe
 */
class Groupe
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $nom;


    /**
     * @var array
     */
    public $adherents;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Groupe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }


    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adherents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add adherent
     *
     * @param \UserBundle\Entity\Adherent $adherent
     *
     * @return Groupe
     */
    public function addAdherent(\UserBundle\Entity\Adherent $adherent)
    {
        $this->adherents[] = $adherent;

        return $this;
    }

    /**
     * Remove adherent
     *
     * @param \UserBundle\Entity\Adherent $adherent
     */
    public function removeAdherent(\UserBundle\Entity\Adherent $adherent)
    {
        $this->adherents->removeElement($adherent);
    }

    /**
     * Get adherents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherents()
    {
        return $this->adherents;
    }
}
