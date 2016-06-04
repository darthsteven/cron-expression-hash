<?php

namespace HashCron;

use Cron\DayOfMonthField;
use mersenne_twister\twister;

class HashDayOfMonthField extends DayOfMonthField {

  protected $hash_data = '';

  /**
   * HashHoursField constructor.
   */
  public function __construct($hash_data = '') {
    $this->hash_data = sha1(get_class($this) . $hash_data);
  }

  protected function replaceHashValueRange($value, $min, $max) {
    if (stripos($value, 'H') !== false) {
      $twister = new twister();
      $twister->init_with_string($this->hash_data);
      $value = str_ireplace('H', $twister->rangeint($min, $max), $value);
    }
    return $value;
  }

  protected function replaceHashValue($value) {
    return $this->replaceHashValueRange($value, 1, 31);
  }

  public function isSatisfiedBy(\DateTime $date, $value)
  {
    return parent::isSatisfiedBy($date, $this->replaceHashValue($value));
  }

  public function validate($value)
  {
    return parent::validate($this->replaceHashValue($value));
  }
}
