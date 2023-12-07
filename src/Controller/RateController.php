<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Currency\Currency;
use App\Factory\PeriodFactory;
use App\Form\MinMaxRateForm;
use App\Repository\Rate\RateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('rates/', name: 'rate_')]
class RateController extends AbstractController
{
    #[Route('min-max', name: 'min_max')]
    public function minMax(Request $request, RateRepository $rateRepository): Response
    {
        $form = $this->createForm(MinMaxRateForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            /** @var Currency $currency */
            $currency = $data['currency'];

            $period = $data['period'];
            $type = $data['type'];

            $value = $rateRepository->findMinMax($currency, PeriodFactory::getPeriod($period), $type);

            $this->addFlash('success',
                sprintf('For currency %s za period %s %s wartość to: %s',
                    $currency->getName(),
                    $period->name,
                    $type->name,
                    $value,
                ));

            return $this->redirectToRoute('rate_min_max');
        }

        return $this->render('rate/min_max.html.twig', [
            'form' => $form,
        ]);
    }
}
