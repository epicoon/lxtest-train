<?php

namespace lx\train\sys\models;

use lx\model\Model;
use lx\model\schema\field\value\TimeValue;

/**
 * Class RefTimeSlotMediator
 * @package lx\train\sys\models
 *
 * @property TimeValue $startTime
 * @property TimeValue $endTime
 */
class RefTimeSlotMediator extends Model
{
    public static function getServiceName(): string
    {
        return 'lx/train';
    }

    public static function getSchemaArray(): array
    {
        return [
            'name' => 'RefTimeSlot',
            'fields' => [
                'startTime' => [
                    'type' => 'time',
                    'required' => true,
                ],
                'endTime' => [
                    'type' => 'time',
                    'required' => true,
                ],
            ],
            'relations' => [],
        ];
    }
}
