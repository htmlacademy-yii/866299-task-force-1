<?php
declare(strict_types = 1);
namespace taskforce\strategies\actions;

/**
 * Класс Action
 */
abstract class Action 
{

    protected $actionName;
    protected $actionInternalName;

    /**
     * Метод возвращает читабельное название действия
     * 
     */
    public function getActionName(): string 
    {
        return $this->actionName;
    }

    /**
     * Метод возвращает внутреннее название действия
     * 
     * @return string
     */
    public function getActionInternalName(): string
    {
        return $this->actionInternalName;
    }

    /**
     * Метод проверяет права доступа к действию
     * 
     * @return bool
     */
    abstract public function isActionAvalible(?int $contractorID, int $clientId, int $userID): bool;
}
