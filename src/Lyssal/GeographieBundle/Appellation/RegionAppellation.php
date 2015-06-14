<?php
namespace Lyssal\GeographieBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\GeographieBundle\Entity\Region;
use Lyssal\GeographieBundle\Decorator\RegionDecorator;

class RegionAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::region()
     */
    public function supports($object)
    {
        return ($object instanceof Region || $object instanceof RegionDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($region)
    {
        return $region->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($region)
    {
        return $this->appellation($region);
    }
}
