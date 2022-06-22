<?php

use taskforce\classes\Task;

require_once 'vendor/autoload.php';

$task = new Task(1,1);

assert($task->getNextStatus('finish') === 'done', 'Error!');