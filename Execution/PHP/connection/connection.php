<?php
$conn = oci_connect('C_HARVEST', 'charvest', '//localhost/xe');


if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
} else {
   // print "Connected to Oracle!";
}
?>