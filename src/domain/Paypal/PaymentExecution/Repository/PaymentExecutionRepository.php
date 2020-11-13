<?php


namespace Payment\Paypal\PaymentExecution\Repository;


use MongoDB\Collection;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PaymentExecutionRepository implements PaymentExecutionRepositoryInterface
{
    /**
     * @var Collection
     */
    private $paymentExecutionCollection;

    /**
     * PaymentIntentRepository constructor.
     * @param Collection $paymentExecutionCollection
     */
    public function __construct(
        Collection $paymentExecutionCollection
    )
    {
        $this->paymentExecutionCollection = $paymentExecutionCollection;
    }


    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return SandboxEnvironment
     */
    public function setEnvironnement(
        string $clientId,
        string $clientSecret
    ): SandboxEnvironment
    {
        return new SandboxEnvironment(
            $clientId,
            $clientSecret
        );
    }




}
