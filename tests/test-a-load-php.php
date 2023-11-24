<?php

/**
 * @package oik-presentation
 * @copyright (C) Copyright Bobbing Wide 2023
 *
 * Unit tests to load all the files for PHP 8.2, except batch ones
 */

class Tests_load_libs extends BW_UnitTestCase
{

	/**
	 * set up logic
	 *
	 * - ensure any database updates are rolled back
	 * - we need oik-googlemap to load the functions we're testing
	 */
	function setUp(): void
	{
		parent::setUp();

	}

	function test_load_admin() {
		$this->load_dir_files( 'admin' );
		$this->assertTrue( true );
	}



	function test_load_includes() {
		//$this->load_dir_files( 'shortcodes' );
		oik_require( 'includes/oikp-lazy-nav.inc', 'oik-presentation');
		$this->assertTrue( true );
	}



	function load_dir_files( $dir, $excludes=[] ) {
		$files = glob( "$dir/*.php");
		//print_r( $files );

		foreach ( $files as $file ) {
			if ( !in_array( $file, $excludes ) ) {
				//echo "Loading $file";
				oik_require( $file, 'oik-presentation');
			}
		}
	}

	/**
	 * Test that the plugin is loaded
	 */
	function test_load_plugin() {
		oik_require( 'oik-presentation.php', 'oik-presentation');
		$this->assertTrue( true );
	}

}