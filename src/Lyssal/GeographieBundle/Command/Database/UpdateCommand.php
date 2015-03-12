<?php
namespace Lyssal\GeographieBundle\Command\Database;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Lyssal\Csv;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LaVendee\GeographieBundle\Entity\Pays;

/**
 * Commande pour remplir la base de données.
 * 
 * @author Rémi Leclerc
 */
class UpdateCommand extends ContainerAwareCommand
{
    /**
     * @var string Chemin vers le dossier de fichiers de LyssalGeographieBundle
     */
    private $cheminLyssalGeographieBundleFiles;
    
    private static $regionsFr = array
    (
        'Alsace' => array('67', '68'),
        'Aquitaine' => array('24', '33', '40', '47', '64'),
        'Auvergne' => array('03', '15', '43', '63'),
        'Basse-Normandie' => array('14', '50', '61'),
        'Bourgogne' => array('58', '71', '89'),
        'Bretagne' => array('22', '29', '35', '56'),
        'Centre - Val de Loire' => array('18', '28', '36', '37', '41', '45'),
        'Champagne-Ardenne' => array('08', '10', '51', '52'),
        'Corse' => array('2A', '2B'),
        'Franche-Comté' => array('25', '39', '70', '90'),
        'Guadeloupe' => array('971'),
        'Guyane' => array('973'),
        'Haute-Normandie' => array('27', '76'),
        'Île-de-France' => array('75', '77', '78', '91', '92', '93', '94', '95'),
        'La Réunion' => array('974'),
        'Languedoc-Roussillon' => array('11', '30', '34', '48', '66'),
        'Limousin' => array('19', '23', '87'),
        'Lorraine' => array('54', '55', '57', '88'),
        'Martinique' => array('972'),
        'Mayotte' => array('976'),
        'Midi-Pyrénées' => array('09', '12', '31', '32', '46', '65', '81', '82'),
        'Nord-Pas-de-Calais' => array('59', '62'),
        'Pays de la Loire' => array('44', '49', '53', '72', '85'),
        'Picardie' => array('02', '60', '80'),
        'Poitou-Charentes' => array('04', '05', '06', '16', '17', '79', '86'),
        'Provence-Alpes-Côte d\'Azur' => array('13', '83', '84'),
        'Rhône-Alpes' => array('01', '07', '26', '38', '42', '69', '73', '74')
    );
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('lyssal:geographie:database:import')
            ->setDescription('Vide et importe les données en base')
        ;
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\DependencyInjection\ContainerAwareInterface::setContainer()
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container->get('doctrine')->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->initCheminLyssalGeographieBundleFiles();
        
        $this->importePays();
    }
    
    /**
     * Initialise le chemin vers le dossier de fichiers de LyssalGeographieBundle.
     *
     * @return void
     */
    private function initCheminLyssalGeographieBundleFiles()
    {
        foreach ($this->container->get('file_locator')->locate('@LyssalGeographieBundle', null, false) as $cheminGeographieBundle)
        {
            if (false !== strpos($cheminGeographieBundle, 'src/Lyssal/GeographieBundle'))
            {
                $this->cheminLyssalGeographieBundleFiles = $cheminGeographieBundle.'../../../files';
                break;
            }
        }
    }
    
    /**
     * Importe en base les pays du monde.
     */
    private function importePays()
    {
        $fichierCsv = new Csv($this->cheminLyssalGeographieBundleFiles.'/csv/pays.csv', ',', '"');
        $fichierCsv->importe(false);
    
        $this->container->get('lyssal.geographie.manager.pays')->removeAll(true);
        $this->container->get('lyssal.geographie.manager.region')->initAutoIncrement();
        $this->container->get('lyssal.geographie.manager.departement')->initAutoIncrement();
        $this->container->get('lyssal.geographie.manager.ville')->initAutoIncrement();
    
        foreach ($fichierCsv->getLignes() as $ligneCsv)
        {
            $codeAlpha2 = $ligneCsv[2];
            $codeAlpha3 = $ligneCsv[3];
            $nomFr = $ligneCsv[4];
            $nomEn = $ligneCsv[5];
    
            $pays = $this->container->get('lyssal.geographie.manager.pays')->create();
    
            $pays->setCodeAlpha2($codeAlpha2);
            $pays->setCodeAlpha3($codeAlpha3);
    
            $pays->setNom($nomFr);
            $pays->setLocale('fr');
    
            $this->container->get('lyssal.geographie.manager.pays')->save($pays);
    
            $pays->setNom($nomEn);
            $pays->setLocale('en');
    
            $this->container->get('lyssal.geographie.manager.pays')->save($pays);
            
            if ('FRA' === $codeAlpha3)
            {
                $this->importeFranceRegions($pays);
                $this->importeFranceDepartements($pays);
                $this->importeFranceVilles($pays);
            }
        }
    }
    
    /**
     * Importe en base les régions françaises.
     */
    private function importeFranceRegions($paysFrance)
    {
        foreach (array_keys(self::$regionsFr) as $regionNom)
        {
            $region = $this->container->get('lyssal.geographie.manager.region')->create();
        
            $region->setNom($regionNom);
            $region->setLocale('fr');
            $region->setPays($paysFrance);
        
            $this->container->get('lyssal.geographie.manager.region')->save($region);
        }
    }

    /**
     * Importe en base les régions françaises.
     */
    private function importeFranceDepartements($paysFrance)
    {
        $fichierCsv = new Csv($this->cheminLyssalGeographieBundleFiles.'/csv/departements-france.csv', ',', '"');
        $fichierCsv->importe(false);
        
        foreach ($fichierCsv->getLignes() as $ligneCsv)
        {
            $code = strtoupper($ligneCsv[1]);
            $nomFr = $ligneCsv[2];
        
            $departement = $this->container->get('lyssal.geographie.manager.departement')->create();
        
            $departement->setCode($code);
            $departement->setRegion($this->getRegionFranceByDepartement($code, $paysFrance));

            $departement->setNom($nomFr);
            $departement->setLocale('fr');
        
            $this->container->get('lyssal.geographie.manager.departement')->save($departement);
        }
    }
    
    /**
     * Retourne la région pour un département français.
     * 
     * @param string Code du département de la région
     * @param \Lyssal\GeographieBundle\Entity\Pays France
     * @return \Lyssal\GeographieBundle\Entity\Region Région
     */
    private function getRegionFranceByDepartement($departementCode, Pays $paysFrance)
    {
        $nomRegion = null;
        foreach (self::$regionsFr as $regionNom => $departementCodes)
        {
            foreach ($departementCodes as $departementCode)
            {
                if ($departementCode == $departementCode)
                {
                    $nomRegion = $regionNom;
                    break;
                }
            }
            if (null !== $nomRegion)
                break;
        }
        if (null === $nomRegion)
            throw new \Exception('Région de France non trouvée pour le code département "'.$departementCode.'".');
        
        return $this->container->get('lyssal.geographie.manager.region')->findOneBy(array('nom' => $nomRegion, 'pays' => $paysFrance));
    }

    /**
     * Importe en base les villes françaises.
     */
    private function importeFranceVilles($paysFrance)
    {
        $departementsByCode = array();
        foreach ($this->container->get('lyssal.geographie.manager.departement')->findByPays($paysFrance) as $departement)
            $departementsByCode[$departement->getCode()] = $departement;
        
        $fichierCsv = new Csv($this->cheminLyssalGeographieBundleFiles.'/csv/villes-france.csv', ',', '"');
        $fichierCsv->importe(false);
    
        $compteur = 0;
        foreach ($fichierCsv->getLignes() as $ligneCsv)
        {
            $codeDepartement = (strlen($ligneCsv[1]) < 2 ? '0' : '').strtoupper($ligneCsv[1]);
            
            if ('975' !== $codeDepartement)
            {
                if (!isset($departementsByCode[$codeDepartement]))
                    throw new \Exception('Le code département "'.$ligneCsv[1].'" de la ville n\'a pas été trouvé.');
                
                $departement = $departementsByCode[$codeDepartement];
                $nomFr = $ligneCsv[5];
                $codePostal = $ligneCsv[8];
                $codeCommune = $ligneCsv[10];
                $latitude = floatval($ligneCsv[19]);
                $longitude = floatval($ligneCsv[20]);
                
                $ville = $this->container->get('lyssal.geographie.manager.ville')->create();
                $ville->setDepartement($departement);
                $ville->setCodePostal($codePostal);
                $ville->setCodeCommune($codeCommune);
                $ville->setLatitude($latitude);
                $ville->setLongitude($longitude);
    
                $ville->setNom($nomFr);
                $ville->setLocale('fr');
                
                $this->container->get('lyssal.geographie.manager.ville')->persist($ville);
                
                if (++$compteur % 100 == 0)
                {
                    $this->container->get('lyssal.geographie.manager.ville')->flush();
                    $this->container->get('lyssal.geographie.manager.ville')->clear();
                }
            }
        }
        
        if (++$compteur % 100 == 0)
        {
            $this->container->get('lyssal.geographie.manager.ville')->flush();
            $this->container->get('lyssal.geographie.manager.ville')->clear();
        }
    }
}
