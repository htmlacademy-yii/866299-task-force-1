<?php

use taskforce\strategies\TaskStrategy;
use taskforce\strategies\actions\ActionCancel;
use taskforce\strategies\actions\ActionDone;
use taskforce\exeptions\TaskActionExeption;
use taskforce\exeptions\TaskStatusExeption;
use taskforce\import\ImportData;
use taskforce\exeptions\BadFileExeption;

use taskforce\import\ConstructorCategories;
use taskforce\import\ConstructorCities;
use taskforce\import\ConstructorUsers;
use taskforce\import\ConstructorTasks;
use taskforce\import\ConstructorReplies;
use taskforce\import\ConstructorOpinions;
use taskforce\import\ConstructorProfiles;

require_once 'vendor/autoload.php';




//проверка на то что корректно работает функция на права доступа к кнопке у классов действий
$actionCancel = new ActionCancel();
assert($actionCancel->isActionAvalible(10, 2, 2) === true, 'проверка что клиент может отменить задание');
assert($actionCancel->isActionAvalible(2, 10, 2) === false, 'проверка что исполнитель не может отменить задание');

$actionDone = new ActionDone();
assert($actionCancel->isActionAvalible(10, 2, 2) === true, 'проверка что клиент может пометить задание как выплненое');
assert($actionCancel->isActionAvalible(2, 10, 2) === false, 'проверка что исполнитель не может пометить задание как выплненое');



$task = new TaskStrategy('new', null, 5, 5);
try {
assert($task->changeStatus(TaskStrategy::ACTION_DONE) === TaskStrategy::STATUS_SUCCESS, 'action_cancel');
assert($task->changeStatus(TaskStrategy::ACTION_CANCEL) === TaskStrategy::STATUS_CANCELLED, 'action_cancel');
assert($task->changeStatus(TaskStrategy::ACTION_FAILED) === TaskStrategy::STATUS_FAILED, 'action_failed');
}
catch (TaskActionExeption $e) {
    print('Не удалось изменить статус задания:' . $e->getMessage());
}

try {
$testTaskOne = new TaskStrategy('new', 10, 5, 5);
assert(current($testTaskOne->getAvailableAction('new')) === 'cancel', 'Проверка на доступные действия пользователь и клиент это один человек. Статус задачи новое');

$testTaskTwo = new TaskStrategy('new', 10, 5, 11);
assert(current($testTaskTwo->getAvailableAction('new')) === 'take', 'Проверка на доступные действия пользователь и клиент разные люди. Статус задачи новое');

$testTaskThree = new TaskStrategy('progress', 14, 10, 10);
assert(current($testTaskThree->getAvailableAction('progress')) === 'done', 'Проверка на доступные действия пользователь и клиент это один человек. Статус задачи в работе');

$testTaskFour = new TaskStrategy('progress', 10, 2, 10);
assert(current($testTaskFour->getAvailableAction('progress')) === 'failed', 'Проверка на доступные действия пользователь и исполнитель это один человек. Статус задачи в работе');

$testTaskFive = new TaskStrategy('new', 10, 5, 10);
assert(current($testTaskFive->getAvailableAction('new'))[0] === NULL, 'Проверка на доступные действия пользователь и исполнитель это один человек.Статус задачи новое');
}
catch (TaskStatusExeption $e) {
    print('Не удалось получить списко возможных действий:' . $e->getMessage());
}



//работа с файлом csv

//добавляем категории
$constructor = new ConstructorCategories;
try {
    $file = new ImportData('categories', ['name','icon']);
    $file->import();
    $file->upload($constructor);
    printf('Файл categories.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}

//добавляем города
$constructor = new ConstructorCities;
try {
    $file = new ImportData('cities', ['city','lat','long']);
    $file->import();
    $file->upload($constructor);
    print('Файл cities.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}

//добавляем пользователей
$constructor = new ConstructorUsers;
try {
    $file = new ImportData('users', ['email','name','password','dt_add']);
    $file->import();
    $file->upload($constructor);
    print('Файл users.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}

//добавляем задачи
$constructor = new ConstructorTasks;
try {
    $file = new ImportData('tasks', ['dt_add','category_id','description','expire','name','address','budget','lat','long']);
    $file->import();
    $file->upload($constructor);
    print('Файл tasks.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}

//добавляем отклики к задачам
$constructor = new ConstructorReplies;
try {
    $file = new ImportData('replies', ['dt_add', 'rate', 'description']);
    $file->import();
    $file->upload($constructor);
    print('Файл replies.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}


//добавляем отзывы к пользователям
$constructor = new ConstructorOpinions;
try {
    $file = new ImportData('opinions', ['dt_add', 'rate', 'description']);
    $file->import();
    $file->upload($constructor);
    print('Файл opinions.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}

//добавляем информацию к юзерам
$constructor = new ConstructorProfiles;
try {
    $file = new ImportData('profiles', ['address', 'bd', 'about', 'phone', 'skype']);
    $file->import();
    $file->upload($constructor);
    print('Файл profiles.sql успешно записан'.PHP_EOL);
}
catch (BadFileExeption $e) {
    print ('Не удалось импортировать файл: ' . $e->getMessage());
}


