<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Payment;
use App\Form\PaymentForm;
use App\Service\CurrenciesParserService\CurrenciesParser;
use App\Service\CurrenciesParserService\Resourse\CurrencyDotComParser;

class IndexController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function newPayment(Request $request, CurrencyDotComParser $currencyDotComParser)
    {
        $currenciesParser = new CurrenciesParser($currencyDotComParser);
        $currencies = $currenciesParser->executeCurrenciesParser();

        $form = $this->createForm(PaymentForm::class, new Payment());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();
            $this->em->persist($payment);
            $this->em->flush();
            $this->addFlash('success', 'Payment saved!');

            return $this->redirectToRoute('new_payment');
        }

        return $this->render('new-payment.html.twig', [
            'form' => $form->createView(),
            'currencies' => $currencies
        ]);
    }
}
