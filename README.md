Getting Started With NlThemeBundle
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

1. Download NlThemeBundle using composer
2. Enable the Bundle
3. Configure the NlThemeBundle

### Step 1: Download NlThemeBundle using composer

Add NlThemeBundle in your composer.json:

```js
{
    "require": {
        "nl/nl-theme-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update nl/nl-theme-bundle
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
        new Admingenerator\NlThemeBundle\NlThemeBundle(),
    );
}
```
### Step 3: Configure the NlThemeBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
# Twig Configuration
twig:
    debug:            %kernel.debug%
    strict_variables: %kernel.debug%
    form:
        resources:
            - 'NlThemeBundle:Form:fields.html.twig'


# Assetic Configuration
assetic:
    debug:          %kernel.debug%
    use_controller: false
    #bundles:        [ ]
    #java: /usr/bin/java
    filters:
        cssrewrite: ~
        lessphp: ~

# Admingenerator Configuration
admingenerator_generator:
    base_admin_template: NlThemeBundle::base_admin.html.twig
    use_doctrine_orm: true
    stylesheets: []
    twig:
        use_localized_date: true
        date_format: 'Y-M-d'
        localized_date_format: 'medium'
        localized_datetime_format: 'medium'
        datetime_format: 'Y-m-d H:i'  
        number_format:
            decimal: 2
            decimal_point: ','
            thousand_separator: ' '
```