<?php

include_once "includes/init.php";

$db = new db();

$db->process_data();

$user = new user();

$user->json = $db->get_json();

$user->register();