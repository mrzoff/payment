<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class PaymentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('amount', NumberType::class, [
            'attr' => ['placeholder' => 'Укажите сумму', 'required' => true],
            'label' => 'Сумма'
        ]);
        $formMapper->add('wallet', TextType::class, [
            'attr' => ['placeholder' => 'Укажите кошелек', 'required' => true], 
            'label' => 'WMZ кошелек',
        ]);        
        if ($this->isCurrentRoute('edit')) {
            $formMapper->add('amount',  NumberType::class, [                
                'attr' => ['readonly' => true]
            ]);
            $formMapper->add('wallet', TextType::class, [                
                'attr' => ['readonly' => true]
                ]);
        }
        $formMapper->add('status', ChoiceType::class, [
            'choices' => [
                'true' => true,
                'false' => false
            ]
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('amount')->add('wallet')->add('status');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('amount')->addIdentifier('wallet')->addIdentifier('status');
    }
}