<?php

namespace HashCron;

use Cron\CronExpression;
use Cron\FieldFactory;

class HashCronExpression extends CronExpression
{
  public static function hashFactory($expression, $hashData = '', FieldFactory $fieldFactory = null)
  {
    $mappings = array(
      '@yearly' => 'H H H H/28 *',
      '@annually' => 'H H H H/28 *',
      '@monthly' => 'H H H * *',
      '@weekly' => 'H H * * H',
      '@daily' => 'H H * * *',
      '@hourly' => 'H * * * *'
    );

    if (isset($mappings[$expression])) {
      $expression = $mappings[$expression];
    }

    return parent::factory($expression, $fieldFactory ?: new HashFieldFactory($hashData));
  }
}