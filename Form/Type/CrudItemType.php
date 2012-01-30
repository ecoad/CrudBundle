<?php
namespace BrowserCreative\CrudBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CrudItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('body', 'textarea', array(
                'error_bubbling' => true));
    }

    public function getDefaultOptions(array $options)
    {
        return array();
    }

    public function getName()
    {
        return 'crud';
    }
}