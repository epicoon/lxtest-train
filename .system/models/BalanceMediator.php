<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DecimalValue;
use lx\train\models\User;

/**
 * Class BalanceMediator
 * @package lx\train\sys\models
 *
 * @property DecimalValue $balance
 * @property User $user
 */
class BalanceMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Balance',
            'fields' => [
                'balance' => [
                    'type' => 'decimal',
                    'details' => [
                        'precision' => 10,
                        'scale' => 2,
                    ],
                    'required' => false,
                    'default' => 0,
                ],
            ],
            'relations' => [
                'user' => [
                    'type' => 'oneToOne',
                    'relatedEntityName' => 'User',
                    'relatedAttributeName' => 'balance',
                    'fkHost' => true,
                ],
            ],
        ];
    }
}
