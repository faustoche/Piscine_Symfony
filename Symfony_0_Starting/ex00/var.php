<?php 

$a = 10;
$b = "10";
$c = "ten";
$d = 10.0;

## On utilise gettype pour identifier le type de chaque variable

print("a contains : " . $a . " and has type : " . gettype($a) . "\n");
print("b contains : " . $b . " and has type : " . gettype($b) . "\n");
print("c contains : " . $c . " and has type : " . gettype($c) . "\n");
print("d contains : " . $d . " and has type : " . gettype($d) . "\n");


?>