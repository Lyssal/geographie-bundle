<?php
namespace Lyssal\GeographieBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\GeographieBundle\Entity\Pays;
use Lyssal\GeographieBundle\Decorator\PaysDecorator;

class PaysAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::pays()
     */
    public function supports($object)
    {
        return ($object instanceof Pays || $object instanceof PaysDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($pays)
    {
        return $pays->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($pays)
    {
        return $this->appellation($pays);
    }
}
