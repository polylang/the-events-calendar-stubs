<?php

return \StubsGenerator\Finder::create()
	->in(
		[
			'vendor/the-events-calendar/the-events-calendar/vendor',
			'vendor/the-events-calendar/the-events-calendar/src',
		]
	)
	->append(
		\StubsGenerator\Finder::create()
			->in(
				[
					'vendor/the-events-calendar/the-events-calendar/common',
				]
			)
			->notPath(
				[
					'src/Tribe/Debug_Bar',
					'vendor/freemius',
				]
			)
	)
	->append(
		\StubsGenerator\Finder::create()
			->in(
				[
					'vendor/the-events-calendar/the-events-calendar',
				]
			)
			->files()
			->depth( '== 0' )
	)
	->sortByName();
