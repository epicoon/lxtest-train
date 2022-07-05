<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Booking;

/**
 * Class RefBookingStatusMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property RelatedModelsCollection&Booking[] $bookings
 */
class RefBookingStatusMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'RefBookingStatus',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'bookings' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Booking',
                    'relatedAttributeName' => 'status',
                ],
            ],
        ];
    }
}
