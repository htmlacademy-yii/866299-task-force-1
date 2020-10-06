<?php
use taskforce\TaskStrategy;
require_once 'vendor/autoload.php';


$task = new TaskStrategy('new', null, 5, 5);
assert($task->changeStatus(TaskStrategy::ACTION_DONE) === TaskStrategy::STATUS_SUCCESS, 'action_done');
assert($task->changeStatus(TaskStrategy::ACTION_CANCEL) === TaskStrategy::STATUS_CANCELLED, 'action_cancel');
assert($task->changeStatus(TaskStrategy::ACTION_FAILED) === TaskStrategy::STATUS_FAILED, 'action_failed');
assert($task->changeStatus(TaskStrategy::ACTION_CONTRACTOR_SELECTED) === TaskStrategy::STATUS_PROGRESS, 'action_contractor_selected');
