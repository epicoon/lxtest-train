<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\train\models\Trip;
use lx\train\models\RefBookingStatus;
use lx\train\models\User;
use lx\train\models\Payment;

/**
 * Class BookingMediator
 * @package lx\train\sys\models
 *
 * @property string $ticket
 * @property Trip $trip
 * @property RefBookingStatus $status
 * @property User $user
 * @property Payment $payment
 */
class BookingMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Booking',
            'fields' => [
                'ticket' => [
                    'type' => 'string',
                    'required' => false,
                ],
            ],
            'relations' => [
                'trip' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Trip',
                    'relatedAttributeName' => 'bookings',
                ],
                'status' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'RefBookingStatus',
                    'relatedAttributeName' => 'bookings',
                ],
                'user' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'User',
                    'relatedAttributeName' => 'bookings',
                ],
                'payment' => [
                    'type' => 'oneToOne',
                    'relatedEntityName' => 'Payment',
                    'relatedAttributeName' => 'booking',
                    'fkHost' => true,
                ],
            ],
        ];
    }
}
