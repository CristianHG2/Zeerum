<?php

namespace Zee;

class Kernel
{
	static $SiteVars;
	
	static function AutoLoad($class)
	{
		$class = str_replace('\\', '/', $class);
		
		if ( file_exists(($path = LIB_DIR.'/'.$class.'.class.php')) )
			return include $path;

		if ( file_exists(($path = DATA_DIR.'/'.$class.'class.php')) )
			return include $path;

		$class = explode('/', $class);
		$class = $class[count($class) - 1];

		if ( \Zee\Model::TableExists($class) )
			return include self::CreateClass($class, '\Zee\Model');
	}

	static function CreateClass($class, $parent = '', $directory = DATA_DIR)
	{
		if ( is_writeable($directory) )
		{
			$path = $directory.'/'.$class.'.class.php';

			var_dump($path);

			file_put_contents($path, '<?php '."\n\n".'namespace Zee\Data; '."\n\n".'class '.$class.(( strlen($parent) > 0 ) ? ' extends '.$parent : '').' { }');

			return $path;
		}
		else
			throw new Exception('Could not write to directory '.$directory);
	}

	static function Halt()
	{
		$Args = func_get_args();

		if ( is_object($Args[0]) )
		{
			$e = $Args[0];
			$e = (object) ['str' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()];
		}
		else
			$e = (object) ['str' => $Args[1], 'file' => $Args[2], 'line' => $Args[3]];

		printf('<br><br><strong>Exception:</strong> %s on file <strong>%s</strong> on line <strong>%s</strong><br><br>', $e->str, $e->file, $e->line);
		debug_print_backtrace();
	}

	static function GetVar($var)
	{
		return self::$SiteVars[$var];
	}

	static function SendBuffer()
	{
		global $page;

		if ( isset($page['id']) )
		{
			$Buffer = new Output($page['id'], $page);

			$Buffer->Vars['site_resources'] = 'https://cherrera.me/portfolio/pms/association';

			$Buffer->Run();

			self::$SiteVars = $Buffer->Vars;
		}
	}
}