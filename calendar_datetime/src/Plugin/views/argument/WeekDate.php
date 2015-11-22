<?php

/**
 * @file
 * Contains \Drupal\calendar_datetime\Plugin\views\argument\WeekDate.
 */

namespace Drupal\calendar_datetime\Plugin\views\argument;

/**
 * Argument handler for a day.
 *
 * @ViewsArgument("datetime_week")
 */
class WeekDate extends Date {

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'W';

}
