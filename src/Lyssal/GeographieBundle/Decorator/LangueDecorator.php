<?php
namespace Lyssal\GeographieBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\GeographieBundle\Entity\Langue;

/**
 * Helper de Langue.
 * 
 * @author Rémi Leclerc
 */
class LangueDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Langue);
    }
}
