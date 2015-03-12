<?php
namespace Lyssal\GeographieBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;
use Lyssal\GeographieBundle\Entity\Pays;

/**
 * Manager de l'entité Departement.
 */
class DepartementManager extends Manager
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Manager\Manager::findAll()
     */
    public function findAll()
    {
        return $this->findBy(array(), array('nom' => 'ASC'));
    }
    
    /**
     * Retourne les départements d'un pays.
     * 
     * @param \Lyssal\GeographieBundle\Entity\Pays Pays
     * @return \Lyssal\GeographieBundle\Entity\Departement[] Départements du pays
     */
    public function findByPays(Pays $pays)
    {
        return $this->getRepository()->findByPays($pays);
    }
}
