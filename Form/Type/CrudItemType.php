<?php
namespace BrowserCreative\CrudBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CrudItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('subject', 'text', array('error_bubbling' => true))
            ->add('body', 'textarea', array('error_bubbling' => true))
            ->add('active', 'checkbox', array('error_bubbling' => true, 'required' => false))
            ->add('imageFile', 'file', array('error_bubbling' => true, 'required' => false))
            ->add('attachmentFile', 'file', array('error_bubbling' => true, 'required' => false))
            ->add('startDate', 'datetime', array('error_bubbling' => true, 'required' => false))
            ->add('endDate', 'datetime', array('error_bubbling' => true, 'required' => false));
    }

    public function getDefaultOptions(array $options)
    {
        return array();
    }

    public function getName()
    {
        return 'crud_item';
    }
}