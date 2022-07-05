<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\DecimalValue;
use lx\train\models\Station;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\StageInTrip;

/**
 * Class StageMediator
 * @package lx\train\sys\models
 *
 * @property int $distance
 * @property DecimalValue $cost
 * @property Station $stationFrom
 * @property Station $stationTo
 * @property RelatedModelsCollection&StageInTrip[] $stagesInTrip
 */
class StageMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Stage',
            'fields' => [
                'distance' => [
                    'type' => 'int',
                    'required' => true,
                ],
                'cost' => [
                    'type' => 'decimal',
                    'details' => [
                        'precision' => 10,
                        'scale' => 2,
                    ],
                    'required' => true,
                ],
            ],
            'relations' => [
                'stationFrom' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Station',
                    'relatedAttributeName' => 'outgoingStages',
                ],
                'stationTo' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Station',
                    'relatedAttributeName' => 'incomingStages',
                ],
                'stagesInTrip' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'StageInTrip',
                    'relatedAttributeName' => 'stage',
                ],
            ],
        ];
    }
}
