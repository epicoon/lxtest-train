<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DateTimeValue;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Transaction;
use lx\train\models\RefPaymentStatus;
use lx\train\models\Booking;

/**
 * Class PaymentMediator
 * @package lx\train\sys\models
 *
 * @property DateTimeValue $createdAt
 * @property RelatedModelsCollection&Transaction[] $transactions
 * @property RefPaymentStatus $status
 * @property Booking $booking
 */
class PaymentMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Payment',
            'fields' => [
                'createdAt' => [
                    'type' => 'datetime',
                    'required' => true,
                ],
            ],
            'relations' => [
                'transactions' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Transaction',
                    'relatedAttributeName' => 'payment',
                ],
                'status' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'RefPaymentStatus',
                    'relatedAttributeName' => 'payments',
                ],
                'booking' => [
                    'type' => 'oneToOne',
                    'relatedEntityName' => 'Booking',
                    'relatedAttributeName' => 'payment',
                ],
            ],
        ];
    }
}
