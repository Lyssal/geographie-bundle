<?php
namespace Lyssal\GeographieBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\GeographieBundle\Entity\Langue;
use Lyssal\GeographieBundle\Decorator\LangueDecorator;

class LangueAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::pays()
     */
    public function supports($object)
    {
        return ($object instanceof Langue || $object instanceof LangueDecorator);
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
    public function appellationHtml($langue)
    {
        return $this->appellation($langue);
    }
}
