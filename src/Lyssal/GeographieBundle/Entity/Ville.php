<?php
namespace Lyssal\GeographieBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Ville.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Ville implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ville_id", type="integer", nullable=false, options={"unsigned":true})
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
     * @ORM\Column(name="ville_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank
     */
    protected $nom;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="ville_slug", length=128, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Departement
     * 
     * @ORM\ManyToOne(targetEntity="Departement", inversedBy="villes")
     * @ORM\JoinColumn(name="departement_id", referencedColumnName="departement_id", nullable=false, onDelete="CASCADE")
     */
    protected $departement;
    
    /**
     * @var string
     * @deprecated since version 0.1.4
     * @ORM\Column(name="ville_code_postal", type="string", nullable=true, length=5)
     */
    protected $codePostal;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="CodePostal", mappedBy="ville", cascade={"persist"})
     */
    protected $codePostaux;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville_code_commune", type="string", nullable=true, length=5)
     */
    protected $codeCommune;
    
    /**
     * @var number
     *
     * @ORM\Column(name="ville_latitude", type="decimal", nullable=true, precision=10, scale=8)
     */
    protected $latitude;
    
    /**
     * @var number
     *
     * @ORM\Column(name="ville_longitude", type="decimal", nullable=true, precision=10, scale=8)
     */
    protected $longitude;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville_description", type="string", nullable=true, length=255)
     * @Gedmo\Translatable
     */
    protected $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville_site_web", type="string", nullable=true, length=128)
     */
    protected $siteWeb;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville_gentile", type="string", nullable=true, length=32)
     */
    protected $gentile;


    /**
     * Constructeur.
     */
    public function __construct()
    {
        $this->codePostaux = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \Lyssal\GeographieBundle\Entity\Ville
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
     * @return Ville
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
     * @return Ville
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
     * Set departement
     *
     * @param \Lyssal\GeographieBundle\Entity\Departement $departement
     * @return Ville
     */
    public function setDepartement(\Lyssal\GeographieBundle\Entity\Departement $departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \Lyssal\GeographieBundle\Entity\Departement 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set codePostal
     *
     * @deprecated since version 0.1.4
     * @param string $codePostal
     * @return Ville
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @deprecated since version 0.1.4
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Add codePostal
     *
     * @param \Lyssal\GeographieBundle\Entity\CodePostal $codePostal
     * @return \Lyssal\GeographieBundle\Entity\Ville
     */
    public function addCodePostal(\Lyssal\GeographieBundle\Entity\CodePostal $codePostal)
    {
        $codePostal->setVille($this);
        $this->codePostaux[] = $codePostal;

        return $this;
    }

    /**
     * Remove codePostaux
     *
     * @param \Lyssal\GeographieBundle\Entity\CodePostal $codePostal
     */
    public function removeCodePostaux(\Lyssal\GeographieBundle\Entity\CodePostal $codePostal)
    {
        $this->codePostaux->removeElement($codePostal);
    }

    /**
     * Get codePostaux
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCodePostaux()
    {
        return $this->codePostaux;
    }

    /**
     * Set codeCommune
     *
     * @param string $codeCommune
     * @return Ville
     */
    public function setCodeCommune($codeCommune)
    {
        $this->codeCommune = $codeCommune;

        return $this;
    }

    /**
     * Get codeCommune
     *
     * @return string 
     */
    public function getCodeCommune()
    {
        return $this->codeCommune;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Ville
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Ville
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ville
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     * @return Ville
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string 
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set gentile
     *
     * @param string $gentile
     * @return Ville
     */
    public function setGentile($gentile)
    {
        $this->gentile = $gentile;

        return $this;
    }
    

    /**
     * Get gentile
     *
     * @return string 
     */
    public function getGentile()
    {
        return $this->gentile;
    }
    
    
    /**
     * ToString.
     *
     * @return string Nom de la ville
     */
    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * Equals.
     *
     * @return boolean Equals
     */
    public function equals(Ville $otherVille)
    {
        return ($this->id === $otherVille->getId());
    }
}
