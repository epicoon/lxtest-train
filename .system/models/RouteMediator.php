<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Parking;
use lx\train\models\RefDayOfWeek;
use lx\train\models\Trip;

/**
 * Class RouteMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property RelatedModelsCollection&Parking[] $parkings
 * @property RelatedModelsCollection&RefDayOfWeek[] $daysOfWeek
 * @property RelatedModelsCollection&Trip[] $trips
 */
class RouteMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'Route',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'parkings' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Parking',
                    'relatedAttributeName' => 'route',
                ],
                'daysOfWeek' => [
                    'type' => 'manyToMany',
                    'relatedEntityName' => 'RefDayOfWeek',
                    'relatedAttributeName' => 'routes',
                ],
                'trips' => [
                    'type' => 'oneToMany',
                    'relatedEntityName' => 'Trip',
                    'relatedAttributeName' => 'route',
                ],
            ],
        ];
    }
}
