<?php


namespace Payment\Account\Service;


use DateTimeInterface;
use Payment\Account\Entity\TransactionEntity;
use Payment\Event\Entity\EventEntity;
use Payment\Event\Entity\EventEntityInterface;
use Payment\Event\Service\EventServiceInterface;

class AccountTransactionService implements AccountTransactionServiceInterface
{

    /**
     * @var EventServiceInterface
     */
    protected $eventService;

    /**
     * AccountTransactionService constructor.
     * @param EventServiceInterface $eventService
     */
    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @inheritDoc
     */
    public function fetchWithAccountIdAndDateRange(
        string $accountId,
        ?DateTimeInterface $fromDate = null,
        ?DateTimeInterface $toDate = null
    )
    {
        $eventCollection = $this
            ->eventService
            ->fetchWithCriteriaAndDateRange(
                [
                    'entityId' => $accountId,
                    'entity' => 'WalletAccount',
                    'actions' => [
                        'AccountBalanceOperation'
                    ]
                ],
                $fromDate instanceof DateTimeInterface ? $fromDate->getTimestamp() : null,
                $toDate instanceof DateTimeInterface ? $toDate->getTimestamp() : null
            );

        return array_map(function (array $event) {
            return [
                'amount' => $event['data']['amount'] ?? null,
                'description' => $event['description'] ?? null,
                'datetime' => $event['timestamp'] ?? null,
                'transactionId' => $event['eventId'] ?? null
            ];
        }, $eventCollection->toArray());
    }

    /**
     * @inheritDoc
     */
    public function create(TransactionEntity $transactionEntity): EventEntityInterface
    {
        return $this
            ->eventService
            ->create(
                EventEntity::fromArray(
                    [
                        'originator' => $transactionEntity->getOriginator(),
                        'originatorId' => $transactionEntity->getOriginatorId(),
                        'entity' => 'WalletAccount',
                        'entityId' => $transactionEntity->getAccountId(),
                        'actions' => [
                            'AccountBalanceOperation',
                            'AccountOperation'
                        ],
                        'description' => $transactionEntity->getDescription(),
                        'timestamp' => time(),
                        'data' => [
                            'amount' => $transactionEntity->getAmount(),
                            'user' => $transactionEntity->getUserId()
                        ]
                    ]
                )
            );
    }
}
