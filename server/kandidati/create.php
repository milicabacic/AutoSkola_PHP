<?php
    require '../broker.php';



    $broker=Broker::getBroker();
    $naziv=$_POST['naziv'];
    $kategorija=$_POST['kategorija'];
    $iskustvo=$_POST['iskustvo'];
    $slika=$_FILES['slika'];
    $napomena=$_POST['napomena'];
    $godiste=$_POST['godiste'];
    $nazivSlike=$slika['name'];
    $lokacija = "../../img/".$nazivSlike;
    if(!move_uploaded_file($_FILES['slika']['tmp_name'],$lokacija)){
        $lokacija="";
      echo json_encode([
          "status"=>false,
          "error"=>"Nije uspelo prebacivanje slike"
      ]);
       
    }else{
        
        $lokacija=substr($lokacija,4);
    }
    
    $rezultat=$broker->izmeni("insert into kandidat (naziv,godiste,kategorija,slika,napomena,iskustvo) values ('".$naziv."',".$godiste.",".$kategorija.",'".$lokacija."','".$napomena."',".$iskustvo.") ");
    echo json_encode($rezultat);
    
    
    


?>