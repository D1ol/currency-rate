<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Currency\Currency;
use App\Entity\Rate\Rate;
use App\Enum\ActionEnum;
use App\Service\ExchangeCurrency\ExchangeCurrency;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ExchangeCurrencyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('amount', NumberType::class, [
                'label' => 'Amount in PLN',
                'html5' => false,
            ])
            ->add('action', EnumType::class, [
                'class' => ActionEnum::class,
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('targetCurrency', EntityType::class, [
                'class' => Currency::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ])
            ->addDependent('rate', 'targetCurrency', function (DependentField $field, ?Currency $currency) {
                if (!$currency) {
                    return;
                }
                $field->add(EntityType::class, [
                    'class' => Rate::class,
                    'choice_label' => fn(Rate $rate) => $rate->getBid() .'/'.$rate->getAsk(),
                    'query_builder' => function (EntityRepository $entityRepository) use ($currency) {
                        $qb = $entityRepository->createQueryBuilder('rate');

                        $qb
                            ->andWhere($qb->expr()->eq('rate.currency', $currency->getId()));

                        return $qb;
                    },
                    'placeholder' => '',
                ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExchangeCurrency::class,
        ]);
    }
}
