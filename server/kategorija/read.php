<?php
    require '../broker.php';
    $broker=Broker::getBroker();
    echo json_encode($broker->vratiKolekciju('SELECT * FROM kategorija'));
