<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Trip;

/**
 * Class TrainMediator
 * @package lx\train\sys\models
 *
 * @property string $code
 * @property int $seatsCount
 * @property RelatedModelsCollection&Trip[] $trips
 */
class TrainMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Train',
            'fields' => [
                'code' => [
                    'type' => 'string',
                    'required' => true,
                ],
                'seatsCount' => [
                    'type' => 'int',
                    'required' => true,
                ],
            ],
            'relations' => [
                'trips' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Trip',
                    'relatedAttributeName' => 'train',
                ],
            ],
        ];
    }
}
