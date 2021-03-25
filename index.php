<?php

use taskforce\strategies\TaskStrategy;
use taskforce\strategies\actions\ActionCancel;
use taskforce\strategies\actions\ActionDone;

require_once 'vendor/autoload.php';




//проверка на то что корректно работает функция на права доступа к кнопке у классов действий
$actionCancel = new ActionCancel();
assert($actionCancel->checkRules(10, 2, 2) === true, 'проверка что клиент может отменить задание');
assert($actionCancel->checkRules(2, 10, 2) === false, 'проверка что исполнитель не может отменить задание');
$actionDone = new ActionDone();
assert($actionCancel->checkRules(10, 2, 2) === true, 'проверка что клиент может пометить задание как выплненое');
assert($actionCancel->checkRules(2, 10, 2) === false, 'проверка что исполнитель не может пометить задание как выплненое');



$task = new TaskStrategy('new', null, 5, 5);
assert($task->changeStatus(TaskStrategy::ACTION_DONE) === TaskStrategy::STATUS_SUCCESS, 'action_cancel');
assert($task->changeStatus(TaskStrategy::ACTION_CANCEL) === TaskStrategy::STATUS_CANCELLED, 'action_cancel');
assert($task->changeStatus(TaskStrategy::ACTION_FAILED) === TaskStrategy::STATUS_FAILED, 'action_failed');
assert($task->changeStatus(TaskStrategy::ACTION_CONTRACTOR_SELECTED) === TaskStrategy::STATUS_PROGRESS, 'action_contractor_selected');


$testTaskOne = new TaskStrategy('new', 10, 5, 5);
assert(current($testTaskOne->getAvailableAction('new')) === 'Отменить задание', 'Проверка на доступные действия пользователь и клиент это один человек. Статус задачи новое');

$testTaskTwo = new TaskStrategy('new', 10, 5, 11);
assert(current($testTaskTwo->getAvailableAction('new')) === 'Откликнуться', 'Проверка на доступные действия пользователь и клиент разные люди. Статус задачи новое');

$testTaskThree = new TaskStrategy('progress', 14, 10, 10);
assert(current($testTaskThree->getAvailableAction('progress')) === 'Выполнено', 'Проверка на доступные действия пользователь и клиент это один человек. Статус задачи в работе');

$testTaskFour = new TaskStrategy('progress', 10, 2, 10);
assert(current($testTaskFour->getAvailableAction('progress')) === 'Отказаться от задания', 'Проверка на доступные действия пользователь и исполнитель это один человек. Статус задачи в работе');

$testTaskFive = new TaskStrategy('new', 10, 5, 10);
assert(current($testTaskFive->getAvailableAction('new'))[0] === NULL, 'Проверка на доступные действия пользователь и исполнитель это один человек.Статус задачи новое');