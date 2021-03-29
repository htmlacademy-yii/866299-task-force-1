<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionTake — наследник класса Action
 * Отклик на задание, выполняет исполнитель
 */
final class ActionTake extends Action 
{
    /**
     * Конструктор класса
     */
    public function __construct()
    {
        $this->actionName = 'Откликнуться';
        $this->actionInternalName = 'take';
    }
    
    /**
     * Метод проверяет права доступа к действию
     * Откликнутся на задание может пользователь, который не является клиентом или исполнителем этой задачи
     */
    public function isActionAvalible(?int $contractorID, int $clientId, int $userID): bool 
    {
        return $userID !== $clientId && $userID !== $contractorID;
    }

}
