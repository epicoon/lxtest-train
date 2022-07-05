<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Platform;
use lx\train\models\Parking;
use lx\train\models\Stage;

/**
 * Class StationMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property RelatedModelsCollection&Platform[] $platforms
 * @property RelatedModelsCollection&Parking[] $parkings
 * @property RelatedModelsCollection&Stage[] $outgoingStages
 * @property RelatedModelsCollection&Stage[] $incomingStages
 */
class StationMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Station',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'platforms' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Platform',
                    'relatedAttributeName' => 'station',
                ],
                'parkings' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Parking',
                    'relatedAttributeName' => 'station',
                ],
                'outgoingStages' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Stage',
                    'relatedAttributeName' => 'stationFrom',
                ],
                'incomingStages' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Stage',
                    'relatedAttributeName' => 'stationTo',
                ],
            ],
        ];
    }
}
