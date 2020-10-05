<?php
use taskforce\TaskStrategy;
require_once 'vendor/autoload.php';


$task = new TaskStrategy('new', 0, 5, 5);
assert($task->changeStatus(TaskStrategy::ACTION_DONE) === TaskStrategy::STATUS_SUCCESS, 'action_done');
assert($task->changeStatus(TaskStrategy::ACTION_CANCEL) === TaskStrategy::STATUS_CANCELLED, 'action_cancel');
assert($task->changeStatus(TaskStrategy::ACTION_FAILED) === TaskStrategy::STATUS_FAILED, 'action_failed');
assert($task->changeStatus(TaskStrategy::ACTION_CONTRACTOR_SELECTED) === TaskStrategy::STATUS_PROGRESS, 'action_contractor_selected');
/**
 * Q:
 * Вроде разобрался пришлось покопаться в php.ini, ассерт выводится warningom так и должно быть?)
 * Warning: assert(): action_done failed in C:\OpenServer\OpenServer\domains\866299-task-force-1\index.php on line 7
 * Просто это довольно удобно, и гораздо удобнее чем просто выводить некое слово или словосочетание на экран
 */