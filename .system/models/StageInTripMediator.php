<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DecimalValue;
use lx\train\models\Trip;
use lx\train\models\Stage;

/**
 * Class StageInTripMediator
 * @package lx\train\sys\models
 *
 * @property DecimalValue $cost
 * @property int $reservedSeatsCount
 * @property Trip $trip
 * @property Stage $stage
 */
class StageInTripMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'StageInTrip',
            'fields' => [
                'cost' => [
                    'type' => 'decimal',
                    'details' => [
                        'precision' => 10,
                        'scale' => 2,
                    ],
                    'required' => false,
                ],
                'reservedSeatsCount' => [
                    'type' => 'int',
                    'required' => false,
                    'default' => 0,
                ],
            ],
            'relations' => [
                'trip' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Trip',
                    'relatedAttributeName' => 'stagesInTrip',
                ],
                'stage' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Stage',
                    'relatedAttributeName' => 'stagesInTrip',
                ],
            ],
        ];
    }
}
