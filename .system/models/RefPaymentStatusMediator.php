<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Payment;

/**
 * Class RefPaymentStatusMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property RelatedModelsCollection&Payment[] $payments
 */
class RefPaymentStatusMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'RefPaymentStatus',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'payments' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Payment',
                    'relatedAttributeName' => 'status',
                ],
            ],
        ];
    }
}
