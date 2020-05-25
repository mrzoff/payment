<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaymentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class, [
                'attr' => ['placeholder' => 'Укажите сумму', 'required' => true],
                'label' => 'Сумма'
            ])
            ->add('wallet', TextType::class, [
                'attr' => ['placeholder' => 'Укажите кошелек', 'required' => true], 
                'label' => 'WMZ кошелек'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить'
            ]);
    }
}


