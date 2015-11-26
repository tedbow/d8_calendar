<?php
/**
 * @file
 * Contains \Drupal\calendar\Plugin\views\argument\YearWeekDate.
 */


namespace Drupal\calendar\Plugin\views\argument;


use Drupal\calendar_datetime\Plugin\views\argument\Date;

/**
 * Argument handler for a day.
 *
 * @ViewsArgument("datetime_year_week")
 */
class YearWeekDate extends Date{

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'YW';

}
