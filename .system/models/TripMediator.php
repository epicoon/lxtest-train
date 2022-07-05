<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DateValue;
use lx\train\models\Route;
use lx\train\models\Train;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\StageInTrip;
use lx\train\models\Booking;

/**
 * Class TripMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property DateValue $departureDate
 * @property DateValue $arrivalDate
 * @property int $totalSeatsCount
 * @property bool $approved
 * @property Route $route
 * @property Train $train
 * @property RelatedModelsCollection&StageInTrip[] $stagesInTrip
 * @property RelatedModelsCollection&Booking[] $bookings
 */
class TripMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Trip',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
                'departureDate' => [
                    'type' => 'date',
                    'required' => true,
                ],
                'arrivalDate' => [
                    'type' => 'date',
                    'required' => true,
                ],
                'totalSeatsCount' => [
                    'type' => 'int',
                    'required' => true,
                ],
                'approved' => [
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                ],
            ],
            'relations' => [
                'route' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Route',
                    'relatedAttributeName' => 'trips',
                ],
                'train' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Train',
                    'relatedAttributeName' => 'trips',
                ],
                'stagesInTrip' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'StageInTrip',
                    'relatedAttributeName' => 'trip',
                ],
                'bookings' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Booking',
                    'relatedAttributeName' => 'trip',
                ],
            ],
        ];
    }
}
