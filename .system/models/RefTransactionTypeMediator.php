<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Transaction;

/**
 * Class RefTransactionTypeMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property RelatedModelsCollection&Transaction[] $transactions
 */
class RefTransactionTypeMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'RefTransactionType',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'transactions' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Transaction',
                    'relatedAttributeName' => 'type',
                ],
            ],
        ];
    }
}
