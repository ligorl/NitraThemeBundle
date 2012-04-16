<?php

namespace Admingenerator\NlThemeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Exception\CreationException;
use Symfony\Component\Form\Extension\Core\ChoiceList\PaddedChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\MonthChoiceList;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToLocalizedStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToArrayTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Symfony\Component\Form\ReversedTransformer;

class DateType extends AbstractType
{
    // only items in $valid_jquery_options will be added to the datepicker() call naturally
    // prepend extra options with "jqd." to add extra options
    // Example:
    //     ... assuming changeMonth was not a standard option ...
    //     $builder->addadd('dob', 'jquery_date', array('format' => 'dd/MM/y','jqd.changeMonth' => 'true')
    //          this wil strip off the 'jqd.' and add to $valid_jquery_options

    protected $valid_jquery_options = array(
        'changeMonth', 'changeYear', 'minDate', 'maxDate', 'showOn', 'yearRange'
    );

    protected $default_jquery_options = array(
        'changeMonth'       => 'false',
        'changeYear'        => 'false',
        'showOn'            => 'focus',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options) {

        foreach ($options as $okey => $ovalue)
        {
            // if the option starts with "jqd." add it to the valid list and set an attribute
            if ( strlen($okey) >=4 && substr($okey, 0, 4) == 'jqd.' )
            {
                $this->valid_jquery_options[] = $okey;
                $builder->setAttribute($okey, $ovalue);
            }

            // if the option is in the valid list, add/set an attribute
            if (array_search($okey, $this->valid_jquery_options))
            {
                $builder->setAttribute($okey, $ovalue);
            }
        }

     $format = $options['format'];
        $pattern = null;

        $allowedFormatOptionValues = array(
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::SHORT,
        );

        // If $format is not in the allowed options, it's considered as the pattern of the formatter if it is a string
        if (!in_array($format, $allowedFormatOptionValues, true)) {
            if (is_string($format)) {
                $defaultOptions = $this->getDefaultOptions($options);

                $format = $defaultOptions['format'];
                $pattern = $options['format'];
            } else {
                throw new CreationException('The "format" option must be one of the IntlDateFormatter constants (FULL, LONG, MEDIUM, SHORT) or a string representing a custom pattern');
            }
        }

        $formatter = new \IntlDateFormatter(
            \Locale::getDefault(),
            $format,
            \IntlDateFormatter::NONE,
            'UTC',
            \IntlDateFormatter::GREGORIAN,
            $pattern
        );

        if ($options['widget'] === 'single_text') {
            $builder->appendClientTransformer(new DateTimeToLocalizedStringTransformer($options['data_timezone'], $options['user_timezone'], $format, \IntlDateFormatter::NONE, \IntlDateFormatter::GREGORIAN, $pattern));
        } else {
            $yearOptions = $monthOptions = $dayOptions = array();

            if ($options['widget'] === 'choice') {
                if (is_array($options['empty_value'])) {
                    $options['empty_value'] = array_merge(array('year' => null, 'month' => null, 'day' => null), $options['empty_value']);
                } else {
                    $options['empty_value'] = array('year' => $options['empty_value'], 'month' => $options['empty_value'], 'day' => $options['empty_value']);
                }

                // Only pass a subset of the options to children
                $yearOptions = array(
                    'choice_list' => new PaddedChoiceList(
                        array_combine($options['years'], $options['years']), 4, '0', STR_PAD_LEFT
                    ),
                    'empty_value' => $options['empty_value']['year'],
                    'required' => $options['required'],
                );
                $monthOptions = array(
                    'choice_list' => new MonthChoiceList(
                        $formatter, $options['months']
                    ),
                    'empty_value' => $options['empty_value']['month'],
                    'required' => $options['required'],
                );
                $dayOptions = array(
                    'choice_list' => new PaddedChoiceList(
                        array_combine($options['days'], $options['days']), 2, '0', STR_PAD_LEFT
                    ),
                    'empty_value' => $options['empty_value']['day'],
                    'required' => $options['required'],
                );
            }

            $builder
                ->add('year', $options['widget'], $yearOptions)
                ->add('month', $options['widget'], $monthOptions)
                ->add('day', $options['widget'], $dayOptions)
                ->appendClientTransformer(new DateTimeToArrayTransformer(
                    $options['data_timezone'], $options['user_timezone'], array('year', 'month', 'day')
                ))
            ;
        }

        if ($options['input'] === 'string') {
            $builder->appendNormTransformer(new ReversedTransformer(
                new DateTimeToStringTransformer($options['data_timezone'], $options['data_timezone'], 'Y-m-d')
            ));
        } elseif ($options['input'] === 'timestamp') {
            $builder->appendNormTransformer(new ReversedTransformer(
                new DateTimeToTimestampTransformer($options['data_timezone'], $options['data_timezone'])
            ));
        } elseif ($options['input'] === 'array') {
            $builder->appendNormTransformer(new ReversedTransformer(
                new DateTimeToArrayTransformer($options['data_timezone'], $options['data_timezone'], array('year', 'month', 'day'))
            ));
        }

        $builder
            ->setAttribute('formatter', $formatter)
            ->setAttribute('widget', $options['widget']);
    }

    public function getDefaultOptions(array $options) {
        $originaloptions = $options;
        $options = array(
            'years'          => range(date('Y') - 5, date('Y') + 5),
            'months'         => range(1, 12),
            'days'           => range(1, 31),
            'widget'         => 'choice',
            'input'          => 'datetime',
            'format'         => \IntlDateFormatter::MEDIUM,
            'data_timezone'  => null,
            'user_timezone'  => null,
            'empty_value'    => null,
            // Don't modify \DateTime classes by reference, we treat
            // them like immutable value objects
            'by_reference'   => false,
            'error_bubbling' => false,
        );
        //Works only with single text
        $options['widget'] = 'single_text';

        // loop through our defined defaults and set them
        foreach ($this->default_jquery_options as $dkey=>$dvalue)
        {
            $options[$dkey] = $dvalue;
        }

        // set a default for any passed options that do not have defaults - prevents kaboom for on-the-fly options
        foreach ($originaloptions as $key=>$value)
        {
            if (!isset($options[$key]))
            {
                $options[$key] = null;
            }
        }

        return $options;
    }

   /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'date';
    }

    /**
     * {@inheritdoc}
     */
    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        $view->set('widget', $form->getAttribute('widget'));

        $pattern = $form->getAttribute('formatter')->getPattern();
        $format = $pattern;

        if ($view->hasChildren()) {

            // set right order with respect to locale (e.g.: de_DE=dd.MM.yy; en_US=M/d/yy)
            // lookup various formats at http://userguide.icu-project.org/formatparse/datetime
            if (preg_match('/^([yMd]+).+([yMd]+).+([yMd]+)$/', $pattern)) {
                $pattern = preg_replace(array('/y+/', '/M+/', '/d+/'), array('{{ year }}', '{{ month }}', '{{ day }}'), $pattern);
            } else {
                // default fallback
                $pattern = '{{ year }}-{{ month }}-{{ day }}';
            }
        }


        $view->set('date_pattern', $pattern);
        $view->set('dateFormat', $this->convertJqueryDate($pattern));

        // initialize an empty array for jqdate options (except dateFormat -- that's handled above)
        $jqdate_options = array();

        foreach ( $this->valid_jquery_options as $okey )
        {
            if ($form->hasAttribute( $okey ))
            {
                // if the option starts with "jqd." strip it off and just use the rest
                if ( strlen($okey) >= 4 && substr($okey, 0, 4) == 'jqd.' )
                {
                    $jqdate_options[substr($okey,4)] = $form->getAttribute($okey);
                }
                else
                {
                    $jqdate_options[$okey] = $form->getAttribute( $okey );
                }

            }

        }

        // add our options array to the view.  we'll loop through this and add all of it to the datepicker() call
        $view->set('jqdate_options', $jqdate_options);

        //////////////////
        $view->set('locale',  'uk' );
    }

    protected function convertJqueryDate($pattern)
    {
      $format = $pattern;
        //jquery use a different syntax, have to replace
        //  php    jquery
        //  MM      mm
        //  MMM     M
        //  MMMM    MM
        //  y       yy

        if (strpos($format, "MMM") > 0) {
            $format = str_replace("MMM", "M", $format);
        } else {
            $format = str_replace("MM", "mm", $format);
        }
        $format = str_replace("LLL", "M", $format);
        $format = str_replace("y", "yy", $format);

       return $format;
    }

}