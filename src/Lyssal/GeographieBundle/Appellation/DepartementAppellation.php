<?php
namespace Lyssal\GeographieBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\GeographieBundle\Entity\Departement;
use Lyssal\GeographieBundle\Decorator\DepartementDecorator;

class DepartementAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::departement()
     */
    public function supports($object)
    {
        return ($object instanceof Departement || $object instanceof DepartementDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($departement)
    {
        return $departement->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($departement)
    {
        return $this->appellation($departement);
    }
}
