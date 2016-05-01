<?php
namespace Lyssal\GeographieBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Région d'un pays.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Region implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="region_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;
    
    /**
     * @var string
     *
     * @ORM\Column(name="region_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank
     * @Gedmo\Translatable
     */
    protected $nom;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="region_slug", length=128, unique=true)
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="Pays", inversedBy="regions")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var array<\Lyssal\GeographieBundle\Entity\Departement>
     * 
     * @ORM\OneToMany(targetEntity="Departement", mappedBy="region")
     */
    protected $departements;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set locale
     *
     * @param string $locale
     * @return \Lyssal\GeographieBundle\Entity\Region
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    
        return $this;
    }
    
    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return Region
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
     * Set slug
     *
     * @param string $slug
     * @return Region
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set pays
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $pays
     * @return Region
     */
    public function setPays(\Lyssal\GeographieBundle\Entity\Pays $pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Lyssal\GeographieBundle\Entity\Pays 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Add departements
     *
     * @param \Lyssal\GeographieBundle\Entity\Departement $departements
     * @return Region
     */
    public function addDepartement(\Lyssal\GeographieBundle\Entity\Departement $departements)
    {
        $this->departements[] = $departements;

        return $this;
    }

    /**
     * Remove departements
     *
     * @param \Lyssal\GeographieBundle\Entity\Departement $departements
     */
    public function removeDepartement(\Lyssal\GeographieBundle\Entity\Departement $departements)
    {
        $this->departements->removeElement($departements);
    }

    /**
     * Get departements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepartements()
    {
        return $this->departements;
    }

    
    /**
     * ToString.
     *
     * @return string Nom de la région
     */
    public function __toString()
    {
        return $this->getNom();
    }
}
