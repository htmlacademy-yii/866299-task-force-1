<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionDone — наследник класса Action
 * Пометить задание как принятое может только заказчик
 */
final class ActionDone extends Action 
{
    /**
     * Конструктор класса
     */
    public function __construct()
    {
        $this->actionName = 'Выполнено';
        $this->actionInternalName = 'done';
    }

    /**
     * Метод проверяет права доступа к действию
     * Пометить как выполненое может только заказчик и только если статус в работе
     */
    public function isActionAvalible(?int $contractorID, int $clientId, int $userID): bool 
    {
        return $userID === $clientId;
    }

}
