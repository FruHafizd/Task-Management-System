<?php
include('tasks.php');
$tasks = new Tasks($db);
$tasks->deleteTaskById();