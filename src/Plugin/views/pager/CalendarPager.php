<?php
/**
 * @file
 * Contains \Drupal\calendar\Plugin\views\pager\CalendarPager.
 */


namespace Drupal\calendar\Plugin\views\pager;


use Drupal\views\Plugin\views\pager\PagerPluginBase;

/**
 * The plugin to handle full pager.
 *
 * @ingroup views_pager_plugins
 *
 * @ViewsPager(
 *   id = "calendar",
 *   title = @Translation("Calendar Pager"),
 *   short_title = @Translation("Calendar"),
 *   help = @Translation("Calendar Pager"),
 *   theme = "calendar_pager",
 * )
 */
class CalendarPager extends PagerPluginBase {
  public function render($input) {
    return array(
      //'#theme' => $this->themeFunctions(), // comment out for testing
      '#theme' => 'calendar_pager',
      '#myvalue' => 'override value',
    );
  }

}
