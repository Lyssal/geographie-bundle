<?php
namespace Lyssal\GeographieBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Département d'une région.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Departement implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="departement_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Region
     * 
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="departements")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="region_id", nullable=false, onDelete="CASCADE")
     */
    protected $region;
    
    /**
     * @var string
     *
     * @ORM\Column(name="departement_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank
     * @Gedmo\Translatable
     */
    protected $nom;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="departement_slug", length=128, unique=true)
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="departement_code", type="string", nullable=false, length=3)
     * @Assert\NotBlank
     */
    protected $code;
    
    /**
     * @var array<\Lyssal\GeographieBundle\Entity\Ville>
     * 
     * @ORM\OneToMany(targetEntity="Ville", mappedBy="departement")
     */
    protected $villes;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->villes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \Lyssal\GeographieBundle\Entity\Departement
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
     * @return Departement
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
     * @return Departement
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
     * Set region
     *
     * @param \Lyssal\GeographieBundle\Entity\Region $region
     * @return Departement
     */
    public function setRegion(\Lyssal\GeographieBundle\Entity\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Lyssal\GeographieBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Departement
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add villes
     *
     * @param \Lyssal\GeographieBundle\Entity\Ville $villes
     * @return Departement
     */
    public function addVille(\Lyssal\GeographieBundle\Entity\Ville $villes)
    {
        $this->villes[] = $villes;

        return $this;
    }

    /**
     * Remove villes
     *
     * @param \Lyssal\GeographieBundle\Entity\Ville $villes
     */
    public function removeVille(\Lyssal\GeographieBundle\Entity\Ville $villes)
    {
        $this->villes->removeElement($villes);
    }

    /**
     * Get villes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVilles()
    {
        return $this->villes;
    }


    /**
     * ToString.
     *
     * @return string Nom du département
     */
    public function __toString()
    {
        return $this->getNom();
    }
}
