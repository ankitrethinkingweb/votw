<?php
session_start();
echo '<title>Hi</title>';
echo 'hi';

function addition($num1 ,$num2)
{
$num3 =$num1 +$num2;
echo $num3;
}

addition(30,40);
?>
