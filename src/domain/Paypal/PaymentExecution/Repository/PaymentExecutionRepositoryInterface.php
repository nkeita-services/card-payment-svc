<?php


namespace Payment\Paypal\PaymentExecution\Repository;

use PayPalCheckoutSdk\Core\SandboxEnvironment;


interface PaymentExecutionRepositoryInterface
{
    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return SandboxEnvironment
     */
    public function setEnvironnement(
        string $clientId,
        string $clientSecret
    ): SandboxEnvironment;

}
