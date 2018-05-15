<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 13/05/2018
 * Time: 17:31
 */

namespace App\Enum;


abstract class ContractStatusEnum
{
    const STATUS_WAITING = "En attente";
    const STATUS_IN_PROGRESS = "En cours";
    const STATUS_FINISHED = "Terminé";

    /** @var array user friendly named status */
    protected static $statusName = [
        self::STATUS_WAITING => "En attente",
        self::STATUS_IN_PROGRESS => "En cours",
        self::STATUS_FINISHED => "Terminé"
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
            self::STATUS_WAITING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_FINISHED,
        ];
    }
}