<?php
use taskforce\TaskStrategy;
require_once 'vendor/autoload.php';


$task = new TaskStrategy('new', null, 5, 5);
assert($task->changingStatus(TaskStrategy::ACTION_DONE) === TaskStrategy::STATUS_SUCCESS, 'ок');

/**
 * Q:
 * Судя по описанию если условие выолняется то должно вывести ок, но ничего не происходит. хотя условие выолняется.
 * Как работает assert
 */