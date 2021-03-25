<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс Action
 * @package taskforce
 */
abstract class Action 
{
    /**
     * Метод возвращает читабельное название действия
     * 
     * @return string
     */
    abstract public function getActionName() : string;

    /**
     * Метод возвращает внутреннее название действия
     * 
     * @return string
     */
    abstract public function getActionInternalName() : string;

    /**
     * Метод проверяет права доступа к действию
     * 
     * @return bool
     */
    abstract public function checkRules(?int $contractorID, int $clientId, int $userID) : bool;
}