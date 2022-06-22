<?php

require_once 'classes/Task.php';

$task = new Task(1, 1);


//if ($task->getNextStatus('finish') === 'done') {
//    echo 'yep!';
//} else {
//    echo 'no-no';
//}

//$i = $task->getPossibleActions('in_work');
//foreach ($i as $a) {
//    echo $a;
//}