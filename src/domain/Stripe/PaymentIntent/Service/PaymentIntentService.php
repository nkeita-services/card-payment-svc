<?php


namespace Payment\Stripe\PaymentIntent\Service;


use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepositoryInterface;
use Stripe\PaymentIntent;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntent as Intent;

class PaymentIntentService implements PaymentIntentServiceInterface
{

    /**
     * @var PaymentIntentRepositoryInterface
     */
    private $paymentIntentRepository;

    /**
     * @var string
     */
    private $publishableKey;

    /**
     * PaymentIntentService constructor.
     * @param PaymentIntentRepositoryInterface $paymentIntentRepository
     * @param string $publishableKey
     */
    public function __construct(
        PaymentIntentRepositoryInterface $paymentIntentRepository,
        string $publishableKey)
    {
        $this->paymentIntentRepository = $paymentIntentRepository;
        $this->publishableKey = $publishableKey;
    }


    /**
     * @inheritDoc
     */
    public function create(
        float $amount,
        string $currency,
        string $accountId
    ): PaymentIntentInterface
    {
        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        $this
            ->paymentIntentRepository
            ->store(
                $intent->client_secret,
                $amount,
                $currency,
                $accountId
            );

        return new Intent(
            $intent->client_secret,
            $amount,
            $accountId,
            $currency,
            $this->publishableKey
        );
    }

    /**
     * @inheritDoc
     */
    public function storeEvent(
        string $clientSecret,
        string $eventType,
        array $event
    ): PaymentIntentInterface{
        $this
            ->paymentIntentRepository
            ->updateWithClientSecret(
                $clientSecret,
                [
                    "events" => [$event]
                ]
            );

        $intent = $this->fromClientSecret(
            $clientSecret
        );

        return $intent->setPublishableKey(
            $this->publishableKey
        );
    }

    /**
     * @inheritDoc
     */
    public function fromClientSecret(string $clientSecret): PaymentIntentInterface
    {
        return $this
            ->paymentIntentRepository
            ->find(
                [
                    'clientSecret' => $clientSecret
                ]
            );
    }


}
