<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Currency\Currency;
use App\Enum\PeriodEnum;
use App\Enum\TypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class MinMaxRateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currency', EntityType::class, [
                'class' => Currency::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('period', EnumType::class, [
                'class' => PeriodEnum::class,
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('type', EnumType::class, [
                'class' => TypeEnum::class,
                'multiple' => false,
                'expanded' => true,
            ]);
    }
}
