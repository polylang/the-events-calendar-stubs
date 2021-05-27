#!/usr/bin/env bash

vendor/bin/generate-stubs \
    --force \
    --finder=finder.php \
    --functions \
    --interfaces \
    --traits \
    --classes \
    --out=the-events-calendar-stubs.php

php remove-duplicates.php
