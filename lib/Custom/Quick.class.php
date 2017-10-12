<?php

namespace Custom;

class Quick
{
	static function AddScript($script, $condition = false)
	{		
		global $page;

		if ( $condition !== false )
		{
			if ( $page['id'] === $condition )
				return '<script src="resources/js/'.$script.'?'.time().'"></script>';
		}
		else
			return '<script src="resources/js/'.$script.'?'.time().'"></script>';

		return '';
	}
}