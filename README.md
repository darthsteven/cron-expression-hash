PHP Cron Expression Hash Parser
==========================

 [![Build Status](https://secure.travis-ci.org/darthsteven/cron-expression-hash.png)](http://travis-ci.org/darthsteven/cron-expression-hash)

This builds upon the fine work done by Michael Dowling in the base [PHP Cron Expression Parser library](https://github.com/mtdowling/cron-expression)

The PHP cron expression parser can parse a CRON expression, determine if it is
due to run, calculate the next run date of the expression, and calculate the previous
run date of the expression.  You can calculate dates far into the future or past by
skipping n number of matching dates.

The parser can handle increments of ranges (e.g. */12, 2-59/3), intervals (e.g. 0-9),
lists (e.g. 1,2,3), W to find the nearest weekday for a given day of the month, L to
find the last day of the month, L to find the last given weekday of a month, and hash
(#) to find the nth weekday of a given month.


Additionally you can also use the literal H instead of a number in most fields and then supply some data to be hashed internally to produce a stable random number instead of H. This allows running lots of different tasks with an hourly schedule: 'H * * * *' but having them actually run at different minutes during the hours.

Installing
==========

Add the dependency to your project:

```bash
composer require darthsteven/cron-expression-hash
```

Usage
=====
```php
<?php

require_once '/vendor/autoload.php';

// Works with predefined scheduling definitions.
$cron = HashCron\HashCronExpression::hashFactory('@daily', 'abc');
$cron->isDue();
echo $cron->getNextRunDate()->format('Y-m-d H:i:s');
echo $cron->getPreviousRunDate()->format('Y-m-d H:i:s');

// Works with literal H characters.
$cron = HashCron\HashCronExpression::hashFactory('H H * * H', 'def');
echo $cron->getNextRunDate()->format('Y-m-d H:i:s');
```

CRON Expressions
================

A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:

    *    *    *    *    *    *
    -    -    -    -    -    -
    |    |    |    |    |    |
    |    |    |    |    |    + year [optional]
    |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
    |    |    |    +---------- month (1 - 12)
    |    |    +--------------- day of month (1 - 31)
    |    +-------------------- hour (0 - 23)
    +------------------------- min (0 - 59)

Requirements
============

- PHP 5.3+
- PHPUnit is required to run the unit tests
- Composer