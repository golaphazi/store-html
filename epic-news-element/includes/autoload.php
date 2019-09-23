<?php

spl_autoload_register(
	function( $class )
	{
		$prefix     = 'EPIC\\';
		$baseDir    = EPIC_DIR . 'includes/class/';
		$len        = strlen( $prefix );

		if ( strncmp( $prefix, $class, $len ) !== 0 )
		{
			return;
		}

		$relativeClass  = substr( $class, $len );
		$file           = rtrim( $baseDir, '/' ) . '/' . str_replace( '\\', '/', $relativeClass ) . '.php';

		if ( is_link( $file ) )
		{
			$file = readlink( $file );
		}

		if ( is_file( $file ) )
		{
			require $file;
		}
	}
);
