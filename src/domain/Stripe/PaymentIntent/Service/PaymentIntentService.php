<?php


namespace Payment\Stripe\PaymentIntent\Service;


use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepositoryInterface;
use Payment\Stripe\PaymentIntent\Service\Exception\PaymentIntentException;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

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
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     * PaymentIntentService constructor.
     * @param string $publishableKey
     * @param CashInTransactionServiceInterface $cashInTransactionService
     */
    public function __construct(
        string $publishableKey,
        CashInTransactionServiceInterface $cashInTransactionService
    )
    {
        $this->publishableKey = $publishableKey;
        $this->cashInTransactionService = $cashInTransactionService;
    }


    /**
     * @inheritDoc
     */
    public function create(
        CashInTransactionEntity $transactionEntity
    ): CashInTransactionEntityInterface
    {
        $transaction = $this
            ->cashInTransactionService
            ->store($transactionEntity);

        try {
            $intent = PaymentIntent::create([
                'amount' => $transactionEntity->getAmount(),
                'currency' => $transactionEntity->getCurrency(),
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);
            $this
                ->cashInTransactionService
                ->addAdditionalInfo(
                    $transaction->getTransactionId(),
                    [
                        'clientSecret' => $intent->client_secret,
                        'publishableKey' => $this->publishableKey
                    ]
                );
            return $this
                ->cashInTransactionService
                ->fetchWithTransactionId(
                    $transaction->getTransactionId()
                );
        } catch (ApiErrorException $e) {
            throw new PaymentIntentException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function storeEvent(
        string $clientSecret,
        string $eventType,
        array $event
    ): CashInTransactionEntityInterface
    {

        $transaction = $this
            ->cashInTransactionService
            ->lookUpExtraInformationFor(
                [
                    'clientSecret' => $clientSecret
                ]
            );


        $this->cashInTransactionService
            ->addTransactionEvent(
                $transaction->getTransactionId(),
                $eventType,
                $event
            );


        return $transaction;
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
