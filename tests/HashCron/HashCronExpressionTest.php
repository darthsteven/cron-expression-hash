<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 03/06/2016
 * Time: 22:06
 */

namespace HashCron\Tests;

use HashCron\HashCronExpression;
use DateTime;

class HashCronExpressionTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers HashCron\HashCronExpression::hashFactory
   */
  public function testFactoryRecognizesTemplates()
  {
    $this->assertEquals('H H H/28 H *', HashCronExpression::hashFactory('@annually')->getExpression());
    $this->assertEquals('H H H/28 H *', HashCronExpression::hashFactory('@yearly')->getExpression());
    $this->assertEquals('H H * * H', HashCronExpression::hashFactory('@weekly')->getExpression());
  }

  /**
   * @dataProvider scheduleProvider
   */
  public function testCanUseHashExpressions($schedule, $relativeTime, $nextRun, $hashData)
  {
    $relativeTimeString = is_int($relativeTime) ? date('Y-m-d H:i:s', $relativeTime) : $relativeTime;

    // Test next run date
    $cron = HashCronExpression::hashFactory($schedule, $hashData);
    if (is_string($relativeTime)) {
      $relativeTime = new DateTime($relativeTime);
    } elseif (is_int($relativeTime)) {
      $relativeTime = date('Y-m-d H:i:s', $relativeTime);
    }
    $next = $cron->getNextRunDate($relativeTime, 0, true);
    $this->assertEquals(new DateTime($nextRun), $next);
  }

  /**
   * Data provider for cron schedule
   *
   * @return array
   */
  public function scheduleProvider()
  {
    return array(
      // Hash minutes
      array('H * * * *', '2016-06-03 00:00:00', '2016-06-03 00:40:00', 'abc'),
      array('H * * * *', '2016-06-03 00:00:00', '2016-06-03 00:10:00', 'def'),
      array('H * * * *', '2016-06-03 00:00:00', '2016-06-03 00:16:00', 'xyz'),
      // Hash hours
      array('* H * * *', '2016-06-03 00:00:00', '2016-06-03 16:00:00', 'abc'),
      array('* H * * *', '2016-06-03 00:00:00', '2016-06-03 19:00:00', 'def'),
      array('* H * * *', '2016-06-03 00:00:00', '2016-06-03 06:00:00', 'xyz'),
      // Hash day of month
      array('* * H * *', '2016-06-03 00:00:00', '2016-06-25 00:00:00', 'abc'),
      array('* * H * *', '2016-06-03 00:00:00', '2016-06-12 00:00:00', 'def'),
      array('* * H * *', '2016-06-03 00:00:00', '2016-06-24 00:00:00', 'xyz'),
      // Hash month
      array('* * * H *', '2016-06-03 00:00:00', '2016-12-01 00:00:00', 'abc'),
      array('* * * H *', '2016-06-03 00:00:00', '2017-02-01 00:00:00', 'def'),
      array('* * * H *', '2016-06-03 00:00:00', '2016-10-01 00:00:00', 'xyz'),
      // Hash day of the week
      array('* * * * H', '2016-06-03 00:00:00', '2016-06-07 00:00:00', 'abc'),
      array('* * * * H', '2016-06-03 00:00:00', '2016-06-05 00:00:00', 'def'),
      array('* * * * H', '2016-06-03 00:00:00', '2016-06-04 00:00:00', 'xyz'),
      // Expressions
      array('@hourly', '2016-06-03 00:00:00', '2016-06-03 00:40:00', 'abc'),
      array('@hourly', '2016-06-03 01:00:00', '2016-06-03 01:10:00', 'def'),
      array('@hourly', '2016-06-03 03:00:00', '2016-06-03 03:16:00', 'xyz'),
      array('@daily', '2016-06-03 00:00:00', '2016-06-03 16:40:00', 'abc'),
      array('@daily', '2016-06-03 00:00:00', '2016-06-03 19:10:00', 'def'),
      array('@daily', '2016-06-03 00:00:00', '2016-06-03 06:16:00', 'xyz'),
      array('@weekly', '2016-06-03 00:00:00', '2016-06-07 16:40:00', 'abc'),
      array('@weekly', '2016-06-03 00:00:00', '2016-06-05 19:10:00', 'def'),
      array('@weekly', '2016-06-03 00:00:00', '2016-06-04 06:16:00', 'xyz'),
      array('@yearly', '2016-06-03 00:00:00', '2016-12-25 16:40:00', 'abc'),
      array('@yearly', '2016-06-03 00:00:00', '2017-02-12 19:10:00', 'def'),
      array('@yearly', '2016-06-03 00:00:00', '2016-10-24 06:16:00', 'xyz'),

    );
  }
}
