<?php

namespace HashCron;

use InvalidArgumentException;
use Cron\FieldFactory;

/**
 * CRON field factory implementing a flyweight factory
 * @link http://en.wikipedia.org/wiki/Cron
 */
class HashFieldFactory extends FieldFactory
{
  /**
   * @var array Cache of instantiated fields
   */
  private $fields = array();

  protected $hash_data = '';

  public function __construct($hash_data = '') {
    $this->hash_data = $hash_data;
  }

  /**
   * Get an instance of a field object for a cron expression position
   *
   * @param int $position CRON expression position value to retrieve
   *
   * @return FieldInterface
   * @throws InvalidArgumentException if a position is not valid
   */
  public function getField($position)
  {
    if (!isset($this->fields[$position])) {
      switch ($position) {
        case 0:
          $this->fields[$position] = new HashMinutesField($this->hash_data);
          break;
        case 1:
          $this->fields[$position] = new HashHoursField($this->hash_data);
          break;
        case 2:
          $this->fields[$position] = new HashDayOfMonthField($this->hash_data);
          break;
        case 3:
          $this->fields[$position] = new HashMonthField($this->hash_data);
          break;
        case 4:
          $this->fields[$position] = new HashDayOfWeekField($this->hash_data);
          break;
        case 5:
          $this->fields[$position] = new \Cron\YearField();
          break;
        default:
          throw new InvalidArgumentException(
            $position . ' is not a valid position'
          );
      }
    }

    return $this->fields[$position];
  }
}
