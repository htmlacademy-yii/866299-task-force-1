<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс ActionFailed — наследник класса Action
 * Отказаться от задания может только исполнитель
 */
final class ActionFailed extends Action 
{
    /**
     * Конструктор класса
     */
    public function __construct()
    {
        $this->actionName = 'Отказаться от задания';
        $this->actionInternalName = 'failed';
    }

    /**
     * Метод проверяет права доступа к действию
     * Отказаться от задания может только исполнитель и только если статус в работе
     */
    public function isActionAvalible(?int $contractorID, int $clientId, int $userID): bool 
    {
        return $userID === $contractorID;
    }

}
