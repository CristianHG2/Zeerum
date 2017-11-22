<?php

namespace Custom;

class Quick
{
	static function AddScript($script, $condition = false)
	{		
		global $page;

		$resourceURL = 'https://cherrera.me/portfolio/pms/association/';

		if ( $condition !== false )
		{
			if ( $page['id'] === $condition )
				return '<script src="'.$resourceURL.'resources/js/'.$script.'?'.time().'"></script>';
		}
		else
			return '<script src="'.$resourceURL.'resources/js/'.$script.'?'.time().'"></script>';

		return '';
	}
}