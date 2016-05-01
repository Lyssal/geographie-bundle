<?php
namespace Lyssal\GeographieBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Langue.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass()
 */
abstract class Langue implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="langue_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
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
     * @ORM\Column(name="langue_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;

    /**
     * @var \Lyssal\GeographieBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays", inversedBy="langues")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var string
     *
     * @ORM\Column(name="langue_code", type="string", nullable=false, length=2)
     * @Assert\NotBlank()
     */
    protected $code;
    
    /**
     * @var string
     *
     * @ORM\Column(name="langue_culture", type="string", nullable=false, length=5)
     * @Assert\NotBlank()
     */
    protected $culture;


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
     * @return \Lyssal\GeographieBundle\Entity\Langue
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
     * @return Langue
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
     * Set pays
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $pays
     * @return Langue
     */
    public function setPays(Pays $pays)
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
     * Set code
     *
     * @param string $code
     * @return Langue
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
     * Set culture
     *
     * @param string $culture
     * @return Langue
     */
    public function setCulture($culture)
    {
        $this->culture = $culture;
    
        return $this;
    }
    
    /**
     * Get culture
     *
     * @return string
     */
    public function getCulture()
    {
        return $this->culture;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
