<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\train\models\Balance;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Booking;

/**
 * Class UserMediator
 * @package lx\train\sys\models
 *
 * @property string $login
 * @property string $role
 * @property Balance $balance
 * @property RelatedModelsCollection&Booking[] $bookings
 */
class UserMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'User',
            'fields' => [
                'login' => [
                    'type' => 'string',
                    'required' => true,
                ],
                'role' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'balance' => [
                    'type' => 'oneToOne',
                    'relatedEntityName' => 'Balance',
                    'relatedAttributeName' => 'user',
                ],
                'bookings' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Booking',
                    'relatedAttributeName' => 'user',
                ],
            ],
        ];
    }
}
