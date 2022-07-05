<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\modelTools\RelatedModelsCollection;
use lx\train\models\Route;

/**
 * Class RefDayOfWeekMediator
 * @package lx\train\sys\models
 *
 * @property string $name
 * @property RelatedModelsCollection&Route[] $routes
 */
class RefDayOfWeekMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'RefDayOfWeek',
            'fields' => [
                'name' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'relations' => [
                'routes' => [
                    'type' => 'manyToMany',
                    'relatedEntityName' => 'Route',
                    'relatedAttributeName' => 'daysOfWeek',
                ],
            ],
        ];
    }
}
