<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionTake — наследник класса Action
 * Отклик на задание, выполняет исполнитель
 * @package taskforcestrategies\actions
 */
class ActionTake extends Action 
{
    /**
     * Метод возвращает читабельное название действия
     * 
     * @return string
     */
    public function getActionName() : string 
    {
        return "Откликнуться";
    }

    /**
     * Метод возвращает внутреннее название действия
     * 
     * @return string
     */
    public function getActionInternalName() : string {
        return "take";
    }
    /**
     * Метод проверяет права доступа к действию
     * Откликнутся на задание может пользователь, который не является клиентом или исполнителем этой задачи
     * 
     * @return bool
     */
    public function checkRules(?int $contractorID, int $clientId, int $userID) : bool 
    {
        if ($userID != $clientId && $userID != $contractorID) {
            return true;
        }
        return false;
    }

}