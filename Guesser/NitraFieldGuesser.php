<?php

namespace Nitra\NitraThemeBundle\Guesser;

use Admingenerator\GeneratorBundle\Guesser\DoctrineORMFieldGuesser;

/**
 * Переопределяем класс для замены виджетов
 */
class NitraFieldGuesser extends DoctrineORMFieldGuesser
{

    public function getFormType($dbType, $columnName)
    {
        if ('date' == $dbType) {
            return 'date';
        }

        return parent::getFormType($dbType, $columnName);
    }

    public function getFormOptions($formType, $dbType, $columnName)
    {
        if ('date' == $dbType) {
            return array('required' => $this->isRequired($columnName), 'format' => 'd MMM y', 'widget' => 'single_text');
        }

        return parent::getFormOptions($formType, $dbType, $columnName);
    }

    public function getFilterOptions($formType, $dbType, $columnName)
    {
        if ('date' == $dbType) {
            return array('required' => false, 'format' => 'd MMM y', 'widget' => 'single_text');
        }

        if ('datetime' == $dbType) {
            return array('required' => false, 'format' => 'd MMM y');
        }

        $options = parent::getFilterOptions($formType, $dbType, $columnName);

        if ('boolean' == $dbType) {
            $options['choices'] = array(
                0 => 'Нет',
                1 => 'Да'
            );
            $options['empty_value'] = '';
        }

        return $options;
    }
    
    public function getFilterType($dbType, $columnName)
    {
        if (in_array($dbType, array('date', 'datetime', 'vardatetime', 'datetimetz'))) {
            return 'date_range';
        }

        return parent::getFilterType($dbType, $columnName);
    }

}
