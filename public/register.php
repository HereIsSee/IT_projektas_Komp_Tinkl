<?php
    require_once '../src/controllers/RegisterController.php';
    require_once '../src/controllers/EventController.php';
    $controllerEvent = new EventController($dbc);
    $data =  $controllerEvent->getCreateEventData();
    require_once '../src/views/register_form.php';
?>