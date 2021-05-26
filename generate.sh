#!/usr/bin/env bash

vendor/bin/generate-stubs \
    --force \
    --functions \
    --interfaces \
    --classes \
    --out=the-events-calendar-stubs.php \
    "vendor/the-events-calendar/the-events-calendar/vendor" "vendor/the-events-calendar/the-events-calendar/src"
