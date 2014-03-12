<?php

# Error definition
error_reporting(-1);
/*
* Pendefinisian fungsi untuk menghindari akses langsung pada file.
* variable yang didefinisi adalah "UMS".
*/
define('UMS',true);

/* Host Name */
define('HOST_NAME','localhost');

/* Username Database */
define('DB_USER','root');

/* Password Database*/
define('DB_PASS','root');

/* Nama Database */
define('DB_NAME','fifa_ums');


# include file koneksi 
require_once('core/db-conn.php');

#Navigasi 
require_once('fa-nav.php');


/* credit
 * Copyright di footer
 */
$credit = "&copy; <a href='#'>fifa</a> Development";