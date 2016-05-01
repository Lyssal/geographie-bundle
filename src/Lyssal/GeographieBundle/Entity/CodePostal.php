<?php
namespace Lyssal\GeographieBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Code postal d'une ville.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass()
 */
abstract class CodePostal implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     * @ORM\Column(name="code_postal_id", type="integer", nullable=false, options={"unsigned":true})
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
     * @var \Lyssal\GeographieBundle\Entity\Ville
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="codePostaux", cascade={"persist"})
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="ville_id", nullable=false, onDelete="CASCADE")
     */
    protected $ville;

    /**
     * @var string
     * @ORM\Column(name="code_postal_code", type="string", nullable=false, length=5)
     * @Assert\NotBlank()
     */
    protected $code;
    
    /**
     * @var string
     * @ORM\Column(name="code_postal_description", type="string", nullable=true, length=255)
     * @Gedmo\Translatable()
     */
    protected $description;


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
     * @return \Lyssal\GeographieBundle\Entity\CodePostal
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
     * Set ville
     *
     * @param \Lyssal\GeographieBundle\Entity\Ville $ville
     * @return \Lyssal\GeographieBundle\Entity\CodePostal
     */
    public function setVille(\Lyssal\GeographieBundle\Entity\Ville $ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Lyssal\GeographieBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return \Lyssal\GeographieBundle\Entity\CodePostal
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
     * Set description
     *
     * @param string $description
     * @return \Lyssal\GeographieBundle\Entity\CodePostal
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
     * ToString.
     *
     * @return string Code postal
     */
    public function __toString()
    {
        return $this->code;
    }
}
