<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\train\models\Station;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Parking;

/**
 * Class PlatformMediator
 * @package lx\train\sys\models
 *
 * @property int $number
 * @property Station $station
 * @property RelatedModelsCollection&Parking[] $parkings
 */
class PlatformMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Platform',
            'fields' => [
                'number' => [
                    'type' => 'int',
                    'required' => true,
                ],
            ],
            'relations' => [
                'station' => [
                    'type' => 'manyToOne',
                    'relatedEntityName' => 'Station',
                    'relatedAttributeName' => 'platforms',
                ],
                'parkings' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Parking',
                    'relatedAttributeName' => 'platform',
                ],
            ],
        ];
    }
}
