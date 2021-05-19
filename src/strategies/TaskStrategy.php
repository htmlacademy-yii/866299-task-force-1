<?php
declare(strict_types = 1);

namespace taskforce\strategies;

use taskforce\strategies\actions\ActionCancel;
use taskforce\strategies\actions\ActionTake;
use taskforce\strategies\actions\ActionDone;
use taskforce\strategies\actions\ActionFailed;
use taskforce\exeptions\TaskActionExeption;
use taskforce\exeptions\TaskStatusExeption;

/**
 * Класс TaskStrategy
 */
final class TaskStrategy
{
    // Статусы задачи
    
    const STATUS_NEW = 'new'; // Задание опубликовано, исполнитель ещё не найден
    const STATUS_CANCELLED = 'cancelled'; // Заказчик отменил задание
    const STATUS_PROGRESS = 'progress'; // Заказчик выбрал исполнителя для задания
    const STATUS_SUCCESS = 'success'; // Заказчик отметил задание как выполненное
    const STATUS_FAILED = 'failed'; // Исполнитель отказался от выполнения задания
   

    // Возможные действия
    /** 
     * Q: зачем эти константы? не проще ли их заменить на классы? ну всмысле на методы классов?
     * Тогда если вдруг нужно будует поменять название с cancel на abort например это нужно будет сделать только в классе
     * Вопрос только как это сделать? Просто удалить их здесь? и везде где они используются заменить на методы из классов действий?
    */

    const ACTION_CANCEL = 'cancel'; // Отменить задание — заказчик (новое)
    const ACTION_TAKE = 'take'; // Откликнуться на задание — исполнитель (новое)
    const ACTION_CONTRACTOR_SELECTED = 'contractor_selected'; //Выбрать исполнителя — заказчик(новое)
    
    const ACTION_DONE = 'done'; // Отметить как выполненое — заказчик (в работе)
    const ACTION_FAILED = 'failed'; // Отказаться от здания — исполнитель (в работе)
    
    
    
    // Свойства класса
    
    public $currentStatus;
    private $contractorID;
    private $clientId;
    private $userID;

    public $actionCancel;
    public $actionTake;
    public $actionDone;
    public $actionFailed;
   

    /**
     * Конструктор класса
     * 
     * @param string $currentStatus текущий статус задания
     * @param int|null $contractorID id исполнителя
     * @param int $clientId id заказчика
     * @param int $userID id текущего юзера
     * 
     */

    public function __construct(string $currentStatus, ?int $contractorID, int $clientId, int $userID)
    {
        $this->currentStatus = $currentStatus;
        if (!isset($this->getStatusMap()[$currentStatus])) {
            throw new TaskStatusExeption('Передан не существующий статус задачи');
        }
        $this->contractorID = $contractorID;
        $this->clientId = $clientId;
        $this->userID = $userID;

        $this->actionCancel = new ActionCancel();
        $this->actionTake = new ActionTake();
        $this->actionDone = new ActionDone();
        $this->actionFailed = new ActionFailed();
    }

    //Методы класса

    /**
     * Создает "карту" статусов
     */
    public function getStatusMap(): array
    {
        return (array) [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_PROGRESS => 'В работе',
            self::STATUS_SUCCESS => 'Выполнено',
            self::STATUS_FAILED => 'Провалено'
        ];
    }

    /**
     * Создает "карту" для действий
     */
    public function getActionMap(): array
    {
        return (array) [
            self::ACTION_CANCEL => $this->actionCancel->getActionName(),
            self::ACTION_TAKE => $this->actionTake->getActionName(),
            self::ACTION_DONE => $this->actionDone->getActionName(),
            self::ACTION_FAILED => $this->actionFailed->getActionName()
        ];
    }

    /**
     * Создает двумерный массив отношений действий к статусам
     */
    public function getActionsToStatus(): array
    {
        $new = array($this->actionCancel, $this->actionTake);
        $progress = array($this->actionDone, $this->actionFailed);
        return array(self::STATUS_NEW=>$new, self::STATUS_PROGRESS=>$progress);
    }

    /**
     * Определяет список доступных действий в зависимости от статуса и роли юзера
     * 
     * @param string $currentStatus текущий статус задачи
     */
    public function getAvailableAction(string $currentStatus): array
    {
        $allActions = $this->getActionsToStatus();
        $avalibleActions = [];
        foreach ($allActions[$currentStatus] as $action) {
            if ($action->isActionAvalible($this->contractorID, $this->clientId, $this->userID)) {
                $avalibleActions[] = $action->getActionInternalName();
            }
        }

        return $avalibleActions;
    }

    /**
     * Меняем статус если были какие-то действия
     * 
     * @param string $action совершенное действие
     */
    public function changeStatus(string $action): string 
    {
        if(!isset($this->getActionMap()[$action])) {
            throw new TaskActionExeption('Передано не существующее действие для задачи');
        }
        switch ($action) {
            case self::ACTION_CANCEL:
                return self::STATUS_CANCELLED;
            break;
            case self::ACTION_DONE:
                return self::STATUS_SUCCESS;
            break;
            case self::ACTION_FAILED:
                return self::STATUS_FAILED;
            break;
            case self::ACTION_CONTRACTOR_SELECTED:
                return self::STATUS_PROGRESS;
            break;
        }
    }
       
    /**
     * Получаем название статуса на русском языке
     *
     * @param string $status внутренее названия статуса задания
     */
    public function getRussianStatus(string $status): string
    {
          return $this->getStatusMap()[$status];
    }

    /**
     * Получаем название действия на русском языке
     *
     * @param string $action внутреннее название действия
     */
    public function getRussianAvailableAction(string $action): string
    {
        return $this->getActionMap()[$action];
    }
}
