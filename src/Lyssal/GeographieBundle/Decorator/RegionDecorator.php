<?php
namespace Lyssal\GeographieBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\GeographieBundle\Entity\Region;

/**
 * Helper de Region.
 * 
 * @author Rémi Leclerc
 */
class RegionDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Region);
    }
}
