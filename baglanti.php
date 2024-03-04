<?php
    try {
        $host='localhost';
        $vtadi='itfaiye';
        $kullanici='root';
        $sifre='';
        $vt=new PDO("mysql:host=$host;dbname=$vtadi;charset=utf8;","$kullanici",$sifre);
        $vt->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");

        
 }
    catch(PDOException $e){
        print $e->getmessage();
 }
?>