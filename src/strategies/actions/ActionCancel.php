<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionCancel
 * Отменяет задание, если оно имеет статус новое и это делает заказчик
 * @package taskforce
 */
class ActionCancel extends Action 
{
    /**
     * Метод возвращает читабельное название действия
     * 
     * @return string
     */
    public function getActionName() : string 
    {
        return "Отменить задание";
    }

    /**
     * Метод возвращает внутреннее название действия
     * 
     * @return string
     */
    public function getActionInternalName() : string {
        return "cancel";
    }
    /**
     * Метод проверяет права доступа к действию
     * Отменить задание может только заказчик и если задание имеет статус новое
     * 
     * @return bool
     */
    public function checkRules(?int $contractorID, int $clientId, int $userID) : bool 
    {
        if ($userID === $clientId) {
            return true;
        }
        return false;
    }

}