<?php

namespace taskforce;

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
     * Q: Вопрос если у нас активна сессия и юзер id нам всегда известен, нужно ли его сюда передавать? 
     * Т.Е я понимаю, что классы как и функции работают по принципу, что передал с тем и работают.
     * Так что мне либо нужно передать сюда id user'a либо как-то получить его внутри класса
     * Теоретически я могу создать класс, который будет всю инфу о юзере получать и использовать этот класс в этом классе?
     */

    //Конструктор класса

    public function __construct($currentStatus, $contractorID, $clientId, $userID)
    {
        $this->currentStatus = $currentStatus;
        $this->contractorID = $contractorID;
        $this->clientId = $clientId;
        $this->userID = $userID;
    }

    //Методы класса

    /**
     * Создает "карту" статусов
     * 
     * @return array
     */
    public function getStatusMap()
    {
        return [
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
    public function getActionMap()
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_TAKE => 'Откликнуться',
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_FAILED => 'Отказаться'
        ];
    } 

    /**
     * Определяем роль юзера для этой задачи
     * 
     * @param int $userID
     * 
     * @return string $role
     */
    private function getUserRole($userID) {
        return ($userID === $this->clientId) ? 'client' : 'contractor';
    }

    /**
     * Определяем список доступных действий в зависимости от статуса и роли юзера
     * 
     * @param string $currentStatus
     * 
     * @return string
     */
    public function getAvalibleAction($currentStatus) {
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
    public function changingStatus($action) {
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
                return self::STATUS_SUCCESS;
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
    public function getRussianStatus($status) {
          return $this->getStatusMap()[$status];
    }

    /**
     * Получаем название действия на русском языке
     *
     * @param string $action
     *
     * @return string $russianAction
     */
    public function getRussianAvalibleAction($action) {
        return $this->getActionMap()[$action];
    }
}