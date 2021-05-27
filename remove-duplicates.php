<?php
namespace Polylang\The_Events_Calendar_Stubs;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

function remove_duplicates_and_fix() {
	$rel_path = 'the-events-calendar-stubs.php';
	$io       = new SymfonyStyle( new ArgvInput(), new ConsoleOutput() );

	$io->title( 'Replacements in stubs' );

	$full_path = __DIR__ . '/' . $rel_path;

	if ( ! file_exists( $full_path ) ) {
		$io->error( "Failed to locate file $rel_path." );
		return;
	}

	$to_remove = [
		'@^\s*/\*\*\s+\*\s+Determine whether a post or content string has blocks\..+/\s*function has_blocks\(.+\)\s*{\s*}\s*$@msU' => '', // `has_blocks()` is a WP function that should be hidden behind `function_exists()`.
		'#@return Context The View current Context instance#' => '@return \Tribe__Context The View current Context instance', // `use Tribe__Context as Context;`
	];
	$replaced  = false;

	try {
		$contents = file_get_contents( $full_path );

		if ( ! is_string( $contents ) ) {
			$io->error( "Failed to open file $rel_path." );
			return;
		}
	} catch( Exception $e ) {
		$io->error( "Failed to open file $rel_path." );
	}

	foreach ( $to_remove as $pattern => $replacement ) {
		$new_contents = preg_replace( $pattern, $replacement, $contents, 1 );

		if ( $new_contents !== $contents && is_string( $new_contents ) ) {
			$replaced = true;
			$contents = $new_contents;
		}
	}

	if ( ! $replaced ) {
		$io->error( "No replacements done in file $rel_path." );
		return;
	}

	$result = file_put_contents( $full_path, $contents );

	if ( false === $result ) {
		$io->error( "Failed to perform replacements in file $rel_path." );
	} else {
		$io->success( "Replacements done in file $rel_path." );
	}
}

remove_duplicates_and_fix();
