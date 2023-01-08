<?php 

echo "<pre>";
var_dump($_SERVER);
echo "</pre>";

#include($_SERVER['DOCUMENT_ROOT'].'/wp-content/tfbuilding/themes/tfbuilding/test.php');

$path = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/tfbuilding/acf/acf.php';

include($path);

#include('/home/86102/domains/tfbuilding.co.uk/html/wp-content/tfbuilding/themes/tfbuilding/test.php');
#include('/home/86102/domains/tfbuilding.co.uk/html/wp-content/themes/tfbuilding/test.php')
#include('/home/86102/domains/tfbuilding.co.uk/html/wp-content/themes/tfbuilding/test.php');

