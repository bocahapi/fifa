<?php
session_start();
/*
* Pengechekan Definisi UMS
*/
if(!isset($_SESSION['login'])){
    die();
}

# include connect database
include_once('./../../fa-config.php');

/**
* 
*/