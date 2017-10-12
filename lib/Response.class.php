<?php

class Response
{
	static function Output($message, $success = true)
	{
		header('Content-Type: application/json');
		
		print(json_encode(['message' => $message, 'success' => $success]));
		exit;
	}
}