<?php


namespace Payment\CashIn\Transaction\Fees;

use MongoDB\Model\BSONDocument;


interface CashInFeesEntityInterface
{

    /**
     * @param BSONDocument $document
     * @return CashInFeesEntityInterface
     */
    public static function  fromMongoDBDocument(
        BSONDocument $document
    ): CashInFeesEntityInterface ;


    /**
     * @param array $data
     * @return CashInFeesEntityInterface
     */
    public static function fromArray(
        array $data
    ): CashInFeesEntityInterface;

    /**
     * @return array
     */
    public function toArray():array;
}
