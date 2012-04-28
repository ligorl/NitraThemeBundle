<?php

namespace Admingenerator\NlThemeBundle\Guesser;

use Admingenerator\GeneratorBundle\Exception\NotImplementedException;
use Admingenerator\GeneratorBundle\Guesser\DoctrineORMFieldGuesser;
use Doctrine\ORM\EntityManager;

/**
 * Переопределяем класс для замены виджетов   
 */
class NlFieldGuesser extends DoctrineORMFieldGuesser {

    public function getFormType($dbType, $columnName) {

        if ('date' == $dbType) {
            return 'date';
        }

        return parent::getFormType($dbType, $columnName);
    }

    public function getFormOptions($formType, $dbType, $columnName) {
        if ('date' == $dbType) {
            return array('required' => true, 'format' => 'd MMM y');
        }

        return parent::getFormOptions($formType, $dbType, $columnName);
    }

    public function getFilterOptions($formType, $dbType, $columnName) {
        if ('date' == $dbType) {
            return array('required' => false, 'format' => 'd MMM y');
        }

        if ('datetime' == $dbType) {
            return array('required' => false, 'format' => 'd MMM y');
        }
        
        return parent::getFilterOptions($formType, $dbType, $columnName);
    }
}
