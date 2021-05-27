<?php
namespace Polylang\The_Events_Calendar_Stubs;

function remove_duplicates_and_fix() {
	$rel_path = 'the-events-calendar-stubs.php';

	echo "Starting replacements in file $rel_path.\n";

	$full_path = __DIR__ . '/' . $rel_path;

	if ( ! file_exists( $full_path ) ) {
		echo "Failed to locate file $rel_path.\n";
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
			echo "Failed to open file $rel_path.\n";
			return;
		}
	} catch( Exception $e ) {
		echo "Failed to open file $rel_path.\n";
	}

	foreach ( $to_remove as $pattern => $replacement ) {
		$new_contents = preg_replace( $pattern, $replacement, $contents, 1 );

		if ( $new_contents !== $contents && is_string( $new_contents ) ) {
			$replaced = true;
			$contents = $new_contents;
		}
	}

	if ( ! $replaced ) {
		echo "No replacements done in file $rel_path.\n";
		return;
	}

	$result = file_put_contents( $full_path, $contents );

	if ( false === $result ) {
		echo "Failed do replacements in file $rel_path.\n";
	} else {
		echo "Replacements successfully done in file $rel_path.\n";
	}
}

remove_duplicates_and_fix();
