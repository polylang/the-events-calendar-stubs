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

	$contents = get_file_contents( $rel_path, $io );

	if ( ! is_string( $contents ) ) {
		return;
	}

	$aliases_contents = get_file_contents( 'vendor/the-events-calendar/the-events-calendar/common/src/functions/aliases.php', $io );

	if ( ! is_string( $aliases_contents ) ) {
		return;
	}

	$aliases_contents = preg_replace(
		'/^<\?php\n/s',
		"<?php\n\nnamespace {",
		$aliases_contents,
		1
	) . "\n}";
	$contents = preg_replace( '/^<\?php/', $aliases_contents, $contents, 1 );

	$to_remove = [
		'@^\s*/\*\*\s+\*\s+Determine whether a post or content string has blocks\..+/\s*function has_blocks\(.+\)\s*{\s*}\s*$@msU' => '', // `has_blocks()` is a WP function that should be hidden behind `function_exists()`.
		'#@return Context The View current Context instance#' => '@return \Tribe__Context The View current Context instance', // `use Tribe__Context as Context;`.
	];

	foreach ( $to_remove as $pattern => $replacement ) {
		$new_contents = preg_replace( $pattern, $replacement, $contents, 1 );

		if ( $new_contents !== $contents && is_string( $new_contents ) ) {
			$contents = $new_contents;
		}
	}

	$result = file_put_contents( __DIR__ . '/' . $rel_path, $contents );

	if ( false === $result ) {
		$io->error( "Failed to perform replacements in file $rel_path." );
	} else {
		$io->success( "Replacements done in file $rel_path." );
	}
}

function get_file_contents( string $rel_path, SymfonyStyle $io ): ?string {
	$full_path = __DIR__ . '/' . $rel_path;

	if ( ! file_exists( $full_path ) ) {
		$io->error( "Failed to locate file $rel_path." );
		return null;
	}

	try {
		$contents = file_get_contents( $full_path );

		if ( ! is_string( $contents ) ) {
			$io->error( "Failed to open file $rel_path." );
			return null;
		}
	} catch( Exception $e ) {
		$io->error( "Failed to open file $rel_path." );
		return null;
	}

	return $contents;
}

remove_duplicates_and_fix();
