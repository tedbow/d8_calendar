<?php
/**
 * @file
 * Contains \Drupal\calendar\DateArgumentWrapper.
 */


namespace Drupal\calendar;


use Drupal\views\Plugin\views\argument\Date;

class DateArgumentWrapper {

  /**
   * @var \Drupal\views\Plugin\views\argument\Date
   */
  protected $dateArg;

  /**
   * @var \DateTime
   */
  protected $min_date;

  /**
   * @var \DateTime
   */
  protected $max_date;

  /**
   * @return Date
   */
  public function getDateArg() {
    return $this->dateArg;
  }

  /**
   * DateArgumentWrapper constructor.
   */
  public function __construct(Date $dateArg) {
    $this->dateArg = $dateArg;
  }

  /**
   * Get the argument date format for the handler.
   *
   * \Drupal\views\Plugin\views\argument\Date has no getter for
   * protected argFormat member.
   *
   * @return string
   */
  protected function getArgFormat() {
    $class = get_class($this->dateArg);
    if (stripos($class, 'YearMonthDate') !== FALSE) {
      return 'Ym';
    }
    if (stripos($class, 'FullDate') !== FALSE) {
      return 'Ymd';
    }
    if (stripos($class, 'YearDate') !== FALSE) {
      return 'Y';
    }
  }

  public function createDateTime() {
    if ($value = $this->dateArg->getValue()) {
      return \DateTime::createFromFormat($this->getArgFormat(), $value);
    }
    return NULL;
  }

  public function format($format) {
    if ($date = $this->createDateTime()) {
      return $date->format($format);
    }
    return NULL;
  }

  public function getGranularity() {
    $plugin_id = $this->dateArg->getPluginId();
    $plugin_granularity = str_replace('datetime_', '', $plugin_id);
    $plugin_granularity = str_replace('date_', '', $plugin_granularity);
    switch ($plugin_granularity) {
      case 'year_month':
        return 'month';
        break;
      // Views and Datetime module don't use same suffix :(.
      case 'full_date':
      case 'fulldate':
        return 'day';
        break;
      case 'year':
        return 'year';
        break;
      // @todo Handle week
      default:
        return 'month';
    }
  }

  /**
   * @return \DateTime
   */
  public function getMinDate() {
    if(!$this->min_date) {
      $date = $this->createDateTime();
      $granularity = $this->getGranularity();
      if ($granularity == 'month') {
        $date->modify("first day of this month");
      }
      elseif ($granularity == 'week') {
        $date->modify('this week');
      }
      elseif ($granularity == 'year') {
        $date->modify("first day of January");
      }
      $date->setTime(0,0,0);
      $this->min_date = $date;
    }
    return $this->min_date;
  }

  /**
   * @return \DateTime
   */
  public function getMaxDate() {
    if(!$this->max_date) {
      $date = $this->createDateTime();
      $granularity = $this->getGranularity();
      if ($granularity == 'month') {
        $date->modify("last day of this month");
      }
      elseif ($granularity == 'week') {
        $date->modify('this week +6 days');
      }
      elseif ($granularity == 'year') {
        $date->modify("last day of December");
      }
      $date->setTime(23,59,59);
      $this->max_date = $date;
    }
    return $this->max_date;
  }

}
