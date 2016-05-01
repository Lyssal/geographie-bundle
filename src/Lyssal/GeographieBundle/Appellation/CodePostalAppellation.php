<?php
namespace Lyssal\GeographieBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\GeographieBundle\Entity\CodePostal;
use Lyssal\GeographieBundle\Decorator\CodePostalDecorator;

class CodePostalAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::ville()
     */
    public function supports($object)
    {
        return ($object instanceof CodePostal || $object instanceof CodePostalDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($codePostal)
    {
        return $codePostal->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($codePostal)
    {
        return $this->appellation($codePostal);
    }
}
