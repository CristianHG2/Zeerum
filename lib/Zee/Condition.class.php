<?php

namespace Zee;

class Condition
{
	public $inits = array('w', 'l', 'o');

	public $wheres = array();

	public function __construct($stmts)
	{
		if ( !is_array($stmts) )
			$stmts = array($stmts);

		foreach ( $stmts as $i )
		{
			$re = '/([a-z])\((.*)\)/';

			preg_match_all($re, $i, $matches, PREG_SET_ORDER, 0);

			$matches = $matches[0];

			if ( !in_array($matches[1], $this->inits) )
				throw new Exception('Unsupported statement '.$matches[1]);

			switch ( $matches[1] )
			{
				case 'w':
					$args = explode(',', $matches[2]);

					if ( count($args) !== 2 )
						throw new Exception('Invalid argument count for statement '.$matches[0]);

					preg_match_all('/([A-z0-9_-]*)/', $args[0], $matches);

					if ( count($matches[0]) !== 2 )
						throw new Exception('Invalid characters for statement '.$matches[0]);

					$this->wheres[] = array($args[0], trim($args[1]));
				break;
			}
		}
	}

	public function getStmt()
	{
		$return = '';

		$params = array();
		$tempArr = array();

		$key = 0;

		foreach ( $this->wheres as $i )
		{
			$key++;
			$tempArr[] = $i[0].' = :'.$key.'_'.$i[0];
			$params[$key.'_'.$i[0]] = $i[1];
		}

		return array('WHERE '.implode(' AND ', $tempArr), $params);
	}
}
