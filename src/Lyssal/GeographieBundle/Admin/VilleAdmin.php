<?php
namespace Lyssal\GeographieBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Classe VilleAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class VilleAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('departement')
            ->add('codePostal')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('codePostal')
            ->add('departement.nom')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom')
            ->add('codePostal')
            ->add('codeCommune')
            ->add('departement')
            ->add('latitude')
            ->add('longitude')
            ->add('description')
            ->add('siteWeb')
            ->add('gentile')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('codePostal')
            ->add('codeCommune')
            ->add('departement')
            ->add('latitude')
            ->add('longitude')
            ->add('description')
            ->add('siteWeb')
            ->add('gentile')
        ;
    }
}
