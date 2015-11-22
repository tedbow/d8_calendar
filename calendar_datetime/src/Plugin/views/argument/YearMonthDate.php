<?php

/**
 * @file
 * Contains \Drupal\calendar_datetime\Plugin\views\argument\YearMonthDate.
 */

namespace Drupal\calendar_datetime\Plugin\views\argument;

/**
 * Argument handler for a day.
 *
 * @ViewsArgument("datetime_year_month")
 */
class YearMonthDate extends Date {

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'Ym';

}
