<?php


namespace Admingenerator\NlThemeBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
//use Symfony\Component\HttpFoundation\Session;

class DateType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{

    public function getDefaultOptions(array $options) {
        $originaloptions = $options;
        $options = parent::getDefaultOptions($options);
        //Works only with single text
        $options['widget'] = 'single_text';

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
    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        $view->set('widget', $form->getAttribute('widget'));
        $pattern = $form->getAttribute('formatter')->getPattern();

        $view->set('date_pattern', $pattern);
        $view->set('dateFormat', $this->convertJqueryDate($pattern));

        $view->set('locale',  \Locale::getDefault());
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