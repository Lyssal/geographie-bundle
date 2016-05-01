<?php
namespace Lyssal\GeographieBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;

/**
 * Manager de l'entité Langue.
 */
class LangueManager extends Manager
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Manager\Manager::findAll()
     */
    public function findAll()
    {
        return $this->getRepository()->findBy(array(), array('nom' => 'ASC'));
    }
}
