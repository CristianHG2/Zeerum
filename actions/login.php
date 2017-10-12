<?php

require '../Init.php';

use \Zee\Input;
use \Zee\Data\Users;

if ( !Input::Set(['user', 'password']) )
	Response::Output('Please fill out all fields', false);

$Condition = Users::Condition(['w(username, '.$_P['user'].')']);

if ( $Condition->RowCount() < 1 )
	Response::Output('No such user and password combination', false);

$Data = $Condition->Select('id', 'password');

if ( !password_verify($_P['password'], $Data[0]['password']) )
	Response::Output('No such user and password combination', false);

$_SESSION['user_id'] = $Data[0]['id'];

Response::Output('Successfully logged in');