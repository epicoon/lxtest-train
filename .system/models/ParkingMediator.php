<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DateIntervalValue;
use lx\train\models\Station;
use lx\train\models\Platform;
use lx\train\models\Route;
use lx\train\models\RefTimeSlot;

/**
 * Class ParkingMediator
 * @package lx\train\sys\models
 *
 * @property int $sequenceOrder
 * @property DateIntervalValue $wayDuration
 * @property DateIntervalValue $stayDuration
 * @property Station $station
 * @property Platform $platform
 * @property Route $route
 * @property RefTimeSlot $incoming
 * @property RefTimeSlot $outgoing
 */
class ParkingMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Parking',
            'fields' => [
                'sequenceOrder' => [
                    'type' => 'int',
                    'required' => true,
                ],
                'wayDuration' => [
                    'type' => 'interval',
                    'required' => true,
                ],
                'stayDuration' => [
                    'type' => 'interval',
                    'required' => true,
                ],
            ],
            'relations' => [
                'station' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Station',
                    'relatedAttributeName' => 'parkings',
                ],
                'platform' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Platform',
                    'relatedAttributeName' => 'parkings',
                ],
                'route' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Route',
                    'relatedAttributeName' => 'parkings',
                ],
                'incoming' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'RefTimeSlot',
                    'relatedAttributeName' => null,
                ],
                'outgoing' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'RefTimeSlot',
                    'relatedAttributeName' => null,
                ],
            ],
        ];
    }
}
