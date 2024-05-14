<?php
$conn = oci_connect('COMMUNITY_HARVEST', 'communityharvest', '//localhost/xe');


if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
} else {
   // print "Connected to Oracle!";
}
?>