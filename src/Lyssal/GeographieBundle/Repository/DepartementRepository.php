<?php
namespace Lyssal\GeographieBundle\Repository;

use Lyssal\StructureBundle\Repository\EntityRepository;
use Lyssal\GeographieBundle\Entity\Pays;

/**
 * Repository de l'entité Departement.
 */
class DepartementRepository extends EntityRepository
{
    /**
     * Retourne les départements d'un pays.
     * 
     * @param \Lyssal\GeographieBundle\Entity\Pays Pays
     * @return \Lyssal\GeographieBundle\Entity\Departement[] Départements du pays
     */
    public function findByPays(Pays $pays)
    {
        $requete = $this->createQueryBuilder('departement');
        
        $requete
            ->innerJoin('departement.region', 'region')
            ->addSelect('region')
            ->where('region.pays = :pays')
            ->setParameter('pays', $pays)
        ;
        
        return $requete->getQuery()->getResult();
    }
}
