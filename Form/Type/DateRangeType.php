<?php

namespace Admingenerator\NlThemeBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class DateRangeType extends \Admingenerator\GeneratorBundle\Form\Type\DateRangeType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        unset($options['years']);

        $options['from']['required'] = $options['required'];
        $options['to']['required'] = $options['required'];
        $options['from']['label'] = 'с';
        $options['to']['label'] = 'по';

        if ($options['format']) {
            $options['from']['format'] = $options['format'];
            $options['to']['format'] = $options['format'];
        }

        $builder
                ->add('from', new DateType(), $options['from'])
                ->add('to', new DateType(), $options['to']);
    }

    public function getDefaultOptions()
    {
        $defaultOptions = parent::getDefaultOptions();
        $defaultOptions['widget'] = 'single_text';
//
//        $options = array_replace($defaultOptions, $options);
//
        if (is_null($defaultOptions['to'])) {
            $defaultOptions['to'] = array('years' => $defaultOptions['years'], 'widget' => 'single_text');
        }

        if (is_null($defaultOptions['from'])) {
            $defaultOptions['from'] = array('years' => $defaultOptions['years'], 'widget' => 'single_text');
        }

        return $defaultOptions;
    }

}
