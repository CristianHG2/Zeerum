<?php

require 'Init.php';

if ( !isset($_SESSION['user_id']) )
	$page['id'] = 'index';
else
	$page['id'] = 'home';