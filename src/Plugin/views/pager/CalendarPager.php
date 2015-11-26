<?php
/**
 * @file
 * Contains \Drupal\calendar\Plugin\views\pager\CalendarPager.
 */


namespace Drupal\calendar\Plugin\views\pager;


use Drupal\calendar\CalendarHelper;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\pager\PagerPluginBase;
use Drupal\views\ViewExecutable;

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
 *   register_theme = FALSE
 * )
 */
class CalendarPager extends PagerPluginBase {

  const NEXT = '+';
  const PREVIOUS = '-';
  /**
   * @var \Drupal\calendar\DateArgumentWrapper;
   */
  protected $argument;
  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->argument = CalendarHelper::getDateArgumentHandler($this->view);
  }


  public function render($input) {
    $path = $this->view->getPath();
    $items['previous'] = [
      'href' => $this->getPagerHref($this::PREVIOUS),
    ];
    $items['next'] = [
      'href' => $this->getPagerHref($this::NEXT),
    ];
    return array(
      '#theme' => $this->themeFunctions(),
      '#items' => $items,
    );
  }

  protected function getPagerArgValue($mode) {
    $datetime = $this->argument->createDateTime();
    $datetime->modify($mode .  '1 ' . $this->argument->getGranularity());
    return $datetime->format($this->argument->getArgFormat());
  }

  protected function getPagerHref($mode) {
    $value = $this->getPagerArgValue($mode);
    $base_path = $this->view->getPath();
    // @todo Handle other arguments
    return '/' . $base_path . '/' . $value;
  }



}
