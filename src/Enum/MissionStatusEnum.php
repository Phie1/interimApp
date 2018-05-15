<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 13/05/2018
 * Time: 17:31
 */

namespace App\Enum;


abstract class MissionStatusEnum
{
    const STATUS_ACTIVE = "Actif";
    const STATUS_DELETED = "Supprimé";

    /** @var array user friendly named status */
    protected static $statusName = [
        self::STATUS_ACTIVE => "Actif",
        self::STATUS_DELETED => "Supprimé",
    ];

    /**
     * @param  string $statusShortName
     * @return string
     */
    public static function getStatusName($statusShortName)
    {
        if (!isset(static::$statusName[$statusShortName])) {
            return "Unknown status ($statusShortName)";
        }

        return static::$statusName[$statusShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableStatus()
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_DELETED,
        ];
    }
}