<?php
declare(strict_types = 1);
namespace taskforce\strategies;

/**
 * Класс TaskStrategy
 * @package taskforce
 */
class TaskStrategy 
{
    // Статусы задачи
    
    const STATUS_NEW = 'new'; // Задание опубликовано, исполнитель ещё не найден
    const STATUS_CANCELLED = 'cancelled'; // Заказчик отменил задание
    const STATUS_PROGRESS = 'progress'; // Заказчик выбрал исполнителя для задания
    const STATUS_SUCCESS = 'success'; // Заказчик отметил задание как выполненное
    const STATUS_FAILED = 'failed'; // Исполнитель отказался от выполнения задания
   

    // Возможные действия

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
        $this->contractorID = $contractorID;
        $this->clientId = $clientId;
        $this->userID = $userID;
    }

    /**
     * Q: Что делать с contractorID? 
     * Дело в том, что при строгой типизации если я туда передам NULL то получаю ошибку.
     * Пока что я придумал только передавать 0. Так как id 0 быть не может.
     */

    //Методы класса

    /**
     * Создает "карту" статусов
     * 
     * @return array
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
     * 
     * @return array
     */
    public function getActionMap(): array
    {
        return (array) [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_TAKE => 'Откликнуться',
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_FAILED => 'Отказаться'
        ];
    } 

    /**
     * Определяет роль юзера для этой задачи
     * 
     * @param int $userID
     * 
     * @return string $role
     */
    private function getUserRole(int $userID): string
    {
        return ($userID === $this->clientId) ? 'client' : 'contractor';
    }

    /**
     * Определяет список доступных действий в зависимости от статуса и роли юзера
     * 
     * @param string $currentStatus
     * 
     * @return string
     */
    public function getAvailableAction(string $currentStatus): string
    {
        $role = $this->getUserRole($this->userID);
        switch ($currentStatus) {
            case self::STATUS_NEW:
                return ($role === 'client') ? self::ACTION_CANCEL : self::ACTION_TAKE;
            break;
            case self::STATUS_PROGRESS:
                return ($role === 'client') ? self::ACTION_DONE : self::ACTION_FAILED;
        }
    }

    /**
     * Меняем статус если были какие-то действия
     * 
     * @param string $action
     * 
     * @return string
     */
    public function changeStatus(string $action): string 
    {
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
     * @param string $status
     *
     * @return string $russianStatus
     */
    public function getRussianStatus(string $status): string
    {
          return $this->getStatusMap()[$status];
    }

    /**
     * Получаем название действия на русском языке
     *
     * @param string $action
     *
     * @return string $russianAction
     */
    public function getRussianAvailableAction(string $action): string
    {
        return $this->getActionMap()[$action];
    }
}