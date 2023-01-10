<?php

declare(strict_types=1);
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

$pitCalendar = new Calendar;
$pitCalendar->useMondayStartingDate();
$standardCalendar = new Calendar;
$standardCalendar->useMondayStartingDate();
$penthouseCalendar = new Calendar;
$penthouseCalendar->useMondayStartingDate();

$pitCalendar->stylesheet();
