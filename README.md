Getting Started With NitraThemeBundle
==================================

## Prerequisites

This version of the bundle requires Symfony 2.1. If you are using Symfony
2.0.x, please use the 2.0 branch of the bundle.

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).

## Installation

Installation is a 3 step process:

1. Download NitraThemeBundle using composer
2. Enable the Bundle
3. Configure the NitraThemeBundle

### Step 1: Download NitraThemeBundle using composer

Add NitraThemeBundle in your composer.json:

```js
{
    "require": {
        "nitra/nitra-theme-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update nitra/nitra-theme-bundle
```
    
Composer will install the bundle to your project's `vendor/nl` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
        new Admingenerator\GeneratorBundle\AdmingeneratorGeneratorBundle(),
        new Millwright\MenuBundle\MillwrightMenuBundle(), 
		new FOS\UserBundle\FOSUserBundle(),
        new Nitra\NitraThemeBundle\NitraThemeBundle(),
    );
}
```
### Step 3: Configure the NitraThemeBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
imports:
    - { resource: menu.yml }
    - { resource: ../../vendor/knplabs/doctrine-behaviors/config/orm-services.yml }

# Twig Configuration
twig:
    debug:            %kernel.debug%
    strict_variables: %kernel.debug%
    form:
        resources:
            - 'NitraThemeBundle:Form:fields.html.twig'


# Assetic Configuration
assetic:
    debug:          %kernel.debug%
    use_controller: false
    #bundles:        [ ]
    #java: /usr/bin/java
    filters:
        cssrewrite: ~
        lessphp: ~

# Doctrine Configuration
doctrine:
    orm:
        filters:
            softdeleteable:
                class: Nitra\NitraThemeBundle\Filter\SoftDeleteableFilter
                enabled: true

# FOS Configuration
fos_user:
    db_driver: orm # other valid values are 'mongodb', 'couchdb' and 'propel'
    firewall_name: main
    user_class: Nitra\NitraThemeBundle\Entity\User
	
# Admingenerator Configuration
admingenerator_generator:
    base_admin_template: ::base_admin.html.twig
    use_doctrine_orm: true
    stylesheets: []
    twig:
        use_localized_date: true
        date_format: 'Y-M-d'
        localized_date_format: 'full'
        localized_datetime_format: 'medium'
        datetime_format: 'Y-m-d H:i'  
        number_format:
            decimal: 2
            decimal_point: ','
            thousand_separator: ' '
			
# 
parameters:
    knp.doctrine_behaviors.blameable_listener.user_entity: Nitra\NitraThemeBundle\Entity\User			
```