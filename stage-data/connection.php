<?php
$host="localhost";
$base="stage-data";
$user="root";
$pwd="";
try {
$cx=new PDO("mysql:host=$host;dbname=$base",$user,$pwd);
} 
catch (PDOexception $i) {
    die("error conection".$i->getMessage());
}
?>
