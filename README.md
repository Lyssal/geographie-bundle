# LyssalGeographieBundle

LyssalGeographieBundle permet la manipulation de différentes données géographiques.

## Entités

Toutes les entités possèdent leur manager et leur gestion administrative (optionnelle) si vous utilisez Sonata.

Les entités sont :
* Pays
* Region
* Departement
* Ville

## Utilisation

Vous devez créer un bundle héritant LyssalGeographieBundle :

```php
namespace Acme\GeographieBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeGeographieBundle extends Bundle
{
    public function getParent()
    {
        return 'LyssalGeographieBundle';
    }
}
```

Ensuite, vous devez créer dans votre bundle les entités héritant celles de LyssalGeographieBundle et redéfinir certaines propriétés :
```php
namespace Acme\GeographieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\GeographieBundle\Entity\Pays as BasePays;

/**
 * Pays du monde.
 * 
 * @ORM\Entity()
 * @ORM\Table
 * (
 *     name="acme_pays",
 *     uniqueConstraints=
 *     {
 *         @UniqueConstraint(name="CODE_ALPHA_2", columns={ "pays_code_alpha_2" }),
 *         @UniqueConstraint(name="CODE_ALPHA_3", columns={ "pays_code_alpha_3" })
 *     }
 * )
 */
class Pays extends BasePays
{
    /**
     * @var array<\Acme\GeographieBundle\Entity\Region>
     * 
     * @ORM\OneToMany(targetEntity="Region", mappedBy="pays")
     */
    protected $regions;
}
```
```php
namespace Acme\GeographieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\GeographieBundle\Entity\Region as BaseRegion;

/**
 * Région d'un pays.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_region")
 */
class Region extends BaseRegion
{
    /**
     * @var \Acme\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="Pays", inversedBy="regions")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @ORM\OneToMany(targetEntity="Departement", mappedBy="region")
     */
    protected $departements;
}
```
```php
namespace Acme\GeographieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\GeographieBundle\Entity\Departement as BaseDepartement;

/**
 * Département d'une région.
 * 
 * @ORM\Entity(repositoryClass="\Lyssal\GeographieBundle\Repository\DepartementRepository")
 * @ORM\Table
 * (
 *     name="acme_departement",
 *     uniqueConstraints=
 *     {
 *         @UniqueConstraint(name="REGION_CODE", columns={ "region_id", "departement_code" })
 *     }
 * )
 */
class Departement extends BaseDepartement
{
    /**
     * @var \Acme\GeographieBundle\Entity\Region
     * 
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="departements")
     * @ORM\JoinColumn(name="reg_id", referencedColumnName="reg_id", nullable=false, onDelete="CASCADE")
     */
    protected $region;
    
    /**
     * @var array<\Acme\GeographieBundle\Entity\Ville>
     * 
     * @ORM\OneToMany(targetEntity="Ville", mappedBy="departement")
     */
    protected $villes;
}
```
```php
namespace Acme\GeographieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\GeographieBundle\Entity\Ville as BaseVille;

/**
 * Ville.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_ville")
 */
class Ville extends BaseVille
{
    /**
     * @var \Acme\GeographieBundle\Entity\Departement
     * 
     * @ORM\ManyToOne(targetEntity="Departement", inversedBy="villes")
     * @ORM\JoinColumn(name="dep_id", referencedColumnName="dep_id", nullable=false, onDelete="CASCADE")
     */
    protected $departement;
}
```

Vous devez ensuite redéfinir les paramètres suivants :

* `lyssal.geographie.entity.departement.class` : Acme\GeographieBundle\Entity\Departement
* `lyssal.geographie.entity.pays.class` : Acme\GeographieBundle\Entity\Pays
* `lyssal.geographie.entity.region.class` : Acme\GeographieBundle\Entity\Region
* `lyssal.geographie.entity.ville.class` : Acme\GeographieBundle\Entity\Ville

Exemple avec sur `Acme/GeographieBundle/Resources/config/services.xml` :

```xml
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <parameters>
        <parameter key="lyssal.geographie.entity.ville.class">Acme\GeographieBundle\Entity\Ville</parameter>
        <parameter key="lyssal.geographie.entity.departement.class">Acme\GeographieBundle\Entity\Departement</parameter>
        <parameter key="lyssal.geographie.entity.region.class">Acme\GeographieBundle\Entity\Region</parameter>
        <parameter key="lyssal.geographie.entity.pays.class">Acme\GeographieBundle\Entity\Pays</parameter>
    </parameters>
</container>
```

## Managers

Les services sont :
* lyssal.geographie.manager.departement
* lyssal.geographie.manager.pays
* lyssal.geographie.manager.region
* lyssal.geographie.manager.ville

### Exemple d'utilisation

Dans votre contrôleur :

```php
$tousLesPays = $this->container->get('lyssal.geographie.manager.pays')->findAll();
```

### Utiliser vos managers hérités de LyssalGeographieBundle

Si vous utilisez vos propres managers héritant des managers de LyssalGeographieBundle, vous pouvez redéfinir les paramètres suivants :
* `lyssal.geographie.manager.departement.class`
* `lyssal.geographie.manager.pays.class`
* `lyssal.geographie.manager.region.class`
* `lyssal.geographie.manager.ville.class`

Exemple en XML :
```xml
<parameters>
    <parameter key="lyssal.geographie.manager.departement.class">Acme\GeographieBundle\Manager\DepartementManager</parameter>
    <parameter key="lyssal.geographie.manager.pays.class">Acme\GeographieBundle\Manager\PaysManager</parameter>
    <parameter key="lyssal.geographie.manager.region.class">Acme\GeographieBundle\Manager\RegionManager</parameter>
    <parameter key="lyssal.geographie.manager.ville.class">Acme\GeographieBundle\Manager\VilleManager</parameter>
</parameters>
```

## SonataAdmin

Les entités seront automatiquement intégrées à SonataAdmin si vous l'avez installé.

Si vous souhaitez redéfinir les classes Admin, il suffit de surcharger les paramètres suivants :
* `lyssal.geographie.admin.departement.class`
* `lyssal.geographie.admin.pays.class`
* `lyssal.geographie.admin.region.class`
* `lyssal.geographie.admin.ville.class`


## Installation

LyssalTourismeBundle utilise `StofDoctrineExtensions` que vous devrez paramétrer pour les traductions (`gedmo_translatable`).


1. Mettez à jour votre `composer.json` :
```json
"require": {
    "lyssal/geographie-bundle": "*"
}
```
2. Installez le bundle :
```sh
php composer.phar update
```
3. Mettez à jour `AppKernel.php` :
```php
new Lyssal\GeographieBundle\LyssalGeographieBundle(),
```
4. Créez les tables en base de données :
```sh
php app/console doctrine:schema:update --force
```

## Commandes

### Importer des données

Vide et importe des données :
```sh
lyssal:geographie:database:import
```

Attention : Les tables seront automatiquement vidées lors de l'appel de cette commande.

Le remplissage de la base concerne :

* Tous les pays avec nom en français et anglais
* Les régions de France avec nom en français
* Les départements de France avec nom en français
* Les villes de France avec nom en français


### CSV

Pour remplir la base de données, `LyssalGeographieBundle` utilisent les CSV de sql.sh pour les pays, les départements et les villes.

Ce(tte) oeuvre de [http://sql.sh](http://sql.sh) est mise à disposition selon les termes de la licence Creative Commons Attribution – Partage dans les Mêmes Conditions 4.0 International(http://creativecommons.org/licenses/by-sa/4.0/).

