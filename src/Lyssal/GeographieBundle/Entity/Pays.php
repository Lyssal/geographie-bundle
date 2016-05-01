<?php
namespace Lyssal\GeographieBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Pays du monde.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Pays implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pays_id", type="smallint", nullable=false, options={"unsigned":true})
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
     * @ORM\Column(name="pays_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="pays_slug", length=128, unique=true)
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pays_code_alpha_2", type="string", nullable=false, length=2)
     */
    protected $codeAlpha2;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_code_alpha_3", type="string", nullable=false, length=3)
     */
    protected $codeAlpha3;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Region", mappedBy="pays")
     */
    protected $regions;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Langue", mappedBy="pays")
     */
    protected $langues;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return \Lyssal\GeographieBundle\Entity\Pays
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
     * @return Pays
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
     * @return Pays
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
     * Set codeAlpha2
     *
     * @param string $codeAlpha2
     * @return Pays
     */
    public function setCodeAlpha2($codeAlpha2)
    {
        $this->codeAlpha2 = $codeAlpha2;

        return $this;
    }

    /**
     * Get codeAlpha2
     *
     * @return string 
     */
    public function getCodeAlpha2()
    {
        return $this->codeAlpha2;
    }

    /**
     * Set codeAlpha3
     *
     * @param string $codeAlpha3
     * @return Pays
     */
    public function setCodeAlpha3($codeAlpha3)
    {
        $this->codeAlpha3 = $codeAlpha3;

        return $this;
    }

    /**
     * Get codeAlpha3
     *
     * @return string 
     */
    public function getCodeAlpha3()
    {
        return $this->codeAlpha3;
    }

    /**
     * Add regions
     *
     * @param \Lyssal\GeographieBundle\Entity\Region $regions
     * @return \Lyssal\GeographieBundle\Entity\Pays
     */
    public function addRegion(\Lyssal\GeographieBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;

        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Lyssal\GeographieBundle\Entity\Region $regions
     */
    public function removeRegion(\Lyssal\GeographieBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Add langue
     *
     * @param \Lyssal\GeographieBundle\Entity\Langue $langue
     * @return \Lyssal\GeographieBundle\Entity\Pays
     */
    public function addLangue(\Lyssal\GeographieBundle\Entity\Langue $langue)
    {
        $this->langues[] = $langue;
    
        return $this;
    }
    
    /**
     * Remove langues
     *
     * @param \Lyssal\GeographieBundle\Entity\Langue $langue
     */
    public function removeLangue(\Lyssal\GeographieBundle\Entity\Langue $langue)
    {
        $this->langues->removeElement($langue);
    }
    
    /**
     * Get langues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangues()
    {
        return $this->langues;
    }
    
    
    
    /**
     * ToString.
     *
     * @return string Nom du pays
     */
    public function __toString()
    {
        return $this->getNom();
    }
}
