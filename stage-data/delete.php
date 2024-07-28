<?php
require "connection.php";
$num=$_REQUEST["numi"];
$deleting="delete from folders where numi='$num'";
$cx->query($deleting);
$msg = 'Deleted Successful!';
echo "<script>alert('$msg');
window.location.href='hello.php';</script>";
?>