<?php

namespace Admingenerator\NlThemeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class DateRangeType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options) {
        unset($options['years']);

        $options['from']['required'] = $options['required'];
        $options['to']['required'] = $options['required'];

        if ($options['format']) {
            $options['from']['format'] = $options['format'];
            $options['to']['format'] = $options['format'];
        }

        $type = $options['date_type'];

        $builder
                ->add('from2', $type, $options['from'])
                ->add('to', $type, $options['to']);

        $builder->setAttribute('widget', $options['widget']);
    }

    public function getParent(array $options) {
        return 'form';
    }

//    public function getDefaultOptions(array $options)
//    {
//        $defaultOptions = array(
//            'format'            => null,
//            'years'             => range(date('Y'), date('Y') - 120),
//            'to'                => null,
//            'from'              => null,
//            'widget'            => 'choice',
//        );
//
//        $options = array_replace($defaultOptions, $options);
//
//        if (is_null($defaultOptions['to'])) {
//            $defaultOptions['to'] = array('years' => $defaultOptions['years'], 'widget' => $defaultOptions['widget']);
//        }
//
//        if (is_null($defaultOptions['from'])) {
//            $defaultOptions['from'] = array('years' => $defaultOptions['years'], 'widget' => $defaultOptions['widget']);
//        }
//
//        return $defaultOptions;
//    }
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form) {

        $view->set('widget', $form->getAttribute('widget'));
    }

    public function getDefaultOptions(array $options) {

        return array(
            'years' => range(date('Y') - 5, date('Y') + 5),
            'months' => range(1, 12),
            'days' => range(1, 31),
            'widget' => 'single_text',
            'input' => 'datetime',
            'format' => \IntlDateFormatter::MEDIUM,
            'data_timezone' => null,
            'user_timezone' => null,
            'empty_value' => null,
            // Don't modify \DateTime classes by reference, we treat
            // them like immutable value objects
            'by_reference' => false,
            'error_bubbling' => false,
            'date_type' => 'date'
        );
    }

    protected function defDateOption() {
        return array(
            'years' => range(date('Y') - 5, date('Y') + 5),
            'months' => range(1, 12),
            'days' => range(1, 31),
            'widget' => 'single_text',
            'input' => 'datetime',
            'format' => \IntlDateFormatter::MEDIUM,
            'data_timezone' => null,
            'user_timezone' => null,
            'empty_value' => null,
            // Don't modify \DateTime classes by reference, we treat
            // them like immutable value objects
            'by_reference' => false,
            'error_bubbling' => false
        );
    }

    public function getName() {
        return 'date_range';
    }

}
