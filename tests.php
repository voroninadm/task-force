<?php
require_once 'vendor/autoload.php';


use taskforce\classes\Task;
use taskforce\classes\actions\ActionRespond;
use taskforce\classes\actions\ActionRefuse;
use taskforce\classes\actions\ActionFinish;
use taskforce\classes\actions\ActionDecline;

$task = new Task(3, 1);
$respond = new ActionRespond();
