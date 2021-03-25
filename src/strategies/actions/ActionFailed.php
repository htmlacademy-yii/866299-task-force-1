<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionFailed — наследник класса Action
 * Отказаться от задания может только исполнитель
 *
 *  @package taskforce
 */
class ActionFailed extends Action 
{
    /**
     * Метод возвращает читабельное название действия
     * 
     * @return string
     */
    public function getActionName() : string 
    {
        return "Отказаться от задания";
    }

    /**
     * Метод возвращает внутреннее название действия
     * 
     * @return string
     */
    public function getActionInternalName() : string {
        return "failed";
    }
    /**
     * Метод проверяет права доступа к действию
     * Отказаться от задания может только исполнитель и только если статус в работе
     * 
     * @return bool
     */
    public function checkRules(?int $contractorID, int $clientId, int $userID) : bool 
    {
        if ($userID === $contractorID ) {
            return true;
        }
        return false;
    }

}