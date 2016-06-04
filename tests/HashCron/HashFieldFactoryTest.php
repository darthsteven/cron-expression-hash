<?php

namespace HashCron\Tests;

use HashCron\HashFieldFactory;

/**
 * @author Steven Jones
 */
class HashFieldFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers HashCron\HashFieldFactory::getField
     */
    public function testRetrievesFieldInstances()
    {
        $mappings = array(
            0 => 'HashCron\HashMinutesField',
            1 => 'HashCron\HashHoursField',
            2 => 'HashCron\HashDayOfMonthField',
            3 => 'HashCron\HashMonthField',
            4 => 'HashCron\HashDayOfWeekField',
            5 => 'Cron\YearField'
        );

        $f = new HashFieldFactory();

        foreach ($mappings as $position => $class) {
            $this->assertEquals($class, get_class($f->getField($position)));
        }
    }

    /**
     * @covers HashCron\HashFieldFactory::getField
     * @expectedException InvalidArgumentException
     */
    public function testValidatesFieldPosition()
    {
        $f = new HashFieldFactory();
        $f->getField(-1);
    }
}
