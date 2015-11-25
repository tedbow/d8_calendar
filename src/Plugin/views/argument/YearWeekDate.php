<?php
/**
 * @file
 * Contains \Drupal\calendar\Plugin\views\argument\YearWeekDate.
 */


namespace Drupal\calendar\Plugin\views\argument;


use Drupal\calendar_datetime\Plugin\views\argument\Date;

class YearWeekDate extends Date{

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'YW';

}
