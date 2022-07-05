<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DecimalValue;
use lx\model\schema\field\value\DateTimeValue;
use lx\train\models\Payment;
use lx\train\models\RefTransactionType;
use lx\train\models\Balance;

/**
 * Class TransactionMediator
 * @package lx\train\sys\models
 *
 * @property DecimalValue $amount
 * @property DateTimeValue $createdAt
 * @property Payment $payment
 * @property RefTransactionType $type
 * @property Balance $balanceFrom
 * @property Balance $balanceTo
 */
class TransactionMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Transaction',
            'fields' => [
                'amount' => [
                    'type' => 'decimal',
                    'details' => [
                        'precision' => 10,
                        'scale' => 2,
                    ],
                    'required' => true,
                ],
                'createdAt' => [
                    'type' => 'datetime',
                    'required' => true,
                ],
            ],
            'relations' => [
                'payment' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Payment',
                    'relatedAttributeName' => 'transactions',
                ],
                'type' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'RefTransactionType',
                    'relatedAttributeName' => 'transactions',
                ],
                'balanceFrom' => [
                    'type' => 'oneToOne',
                    'relatedEntityName' => 'Balance',
                    'relatedAttributeName' => null,
                    'fkHost' => true,
                ],
                'balanceTo' => [
                    'type' => 'oneToOne',
                    'relatedEntityName' => 'Balance',
                    'relatedAttributeName' => null,
                    'fkHost' => true,
                ],
            ],
        ];
    }
}
