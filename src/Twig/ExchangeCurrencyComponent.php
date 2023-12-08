<?php

namespace App\Twig;

use App\Form\ExchangeCurrencyForm;
use App\Service\ExchangeCurrency\ExchangeCurrency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(name: 'exchange_currency_component')]
class ExchangeCurrencyComponent extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ExchangeCurrencyForm::class, new ExchangeCurrency());
    }

    #[LiveAction]
    public function exchange(): RedirectResponse
    {
        $this->submitForm();

        /** @var ExchangeCurrency $data */
        $data = $this->getForm()->getData();

        $this->addFlash('success', sprintf('Expected amount in %s is: %s', $data->getTargetCurrency()->getSymbol(), $data->getExchangedAmount()));

        return $this->redirectToRoute('rate_exchange');
    }
}
