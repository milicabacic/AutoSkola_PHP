<?php
    require '../broker.php';
    $broker=Broker::getBroker();
   
    $naziv=$_POST['naziv'];
    if(!preg_match('/^[a-zA-Z\s]*$/',$naziv)){
        echo json_encode([
            'status'=>false,
            'error'=>'Naziv iskustva sme da se sastoji samo od slova!'
        ]);
    }else{
        $rezultat=$broker->izmeni("insert into iskustvo(naziv) values ('".$naziv."') ");
       echo json_encode($rezultat);
    }
