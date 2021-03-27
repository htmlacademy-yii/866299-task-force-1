<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionCancel
 * Отменяет задание, если оно имеет статус новое и это делает заказчик
 */
final class ActionCancel extends Action 
{
    /**
     * Конструктор класса
     */
    public function __construct()
    {
        $this->actionName = 'Отменить задание';
        $this->actionInternalName = 'cancel';
    }

    /**
     * Метод проверяет права доступа к действию
     * Отменить задание может только заказчик и если задание имеет статус новое
     */
    public function isActionAvalible(?int $contractorID, int $clientId, int $userID): bool 
    {
        return $userID === $clientId;
    }

}
