<?php

/**
 * @file
 * Contains \Drupal\calendar_datetime\Plugin\views\argument\FullDate.
 */

namespace Drupal\calendar_datetime\Plugin\views\argument;


/**
 * Argument handler for a day.
 *
 * @ViewsArgument("datetime_full_date")
 */
class FullDate extends Date {

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'Ymd';

}
