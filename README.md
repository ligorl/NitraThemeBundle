# Тема для symfony2 generator#

## Установка

Добавить в deps
````
[NlThemeBundle]
    git=git://github.com/vitaliytv/NlThemeBundle.git
    target=/bundles/Admingenerator/NlThemeBundle
````

Добавить в `AppKernel` класс:

````
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Admingenerator\NlThemeBundle\NlThemeBundle(),
    );

    // ...
}
````

## config.yml

````
twig:
    form:
        resources:
            - 'NlThemeBundle:Form:fields.html.twig'

admingenerator_generator:
    base_admin_template: NlThemeBundle::base_admin.html.twig
````

Публикация:

````
    php app/console assets:install web
````