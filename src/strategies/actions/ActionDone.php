<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionDone — наследник класса Action
 * Пометить задание как принятое может только заказчик
 *
 *  @package taskforce
 */
class ActionDone extends Action 
{
    /**
     * Метод возвращает читабельное название действия
     * 
     * @return string
     */
    public function getActionName() : string 
    {
        return "Выполнено";
    }

    /**
     * Метод возвращает внутреннее название действия
     * 
     * @return string
     */
    public function getActionInternalName() : string {
        return "done";
    }
    /**
     * Метод проверяет права доступа к действию
     * Пометить как выполненое может только заказчик и только если статус в работе
     * 
     * @return bool
     */
    public function checkRules(?int $contractorID, int $clientId, int $userID) : bool 
    {
        if ($userID === $clientId ) {
            return true;
        }
        return false;
    }

}