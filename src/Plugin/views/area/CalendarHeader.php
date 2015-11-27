<?php

/**
 * @file
 * Contains \Drupal\calendar\Plugin\views\area\CalendarHeader.
 */

namespace Drupal\calendar\Plugin\views\area;

use Drupal\calendar\CalendarHelper;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\area\TokenizeAreaPluginBase;

/**
 * Views area text handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("calendar_header")
 */
class CalendarHeader extends TokenizeAreaPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    // Override defaults to from parent.
    $options['tokenize']['default'] = TRUE;
    $options['empty']['default'] = TRUE;
    // Provide our own default.
    $options['heading'] = array('default' => '');
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['heading'] = array(
      '#title' => $this->t('Heading'),
      '#type' => 'textfield',
      '#default_value' => $this->options['heading'],
    );
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {

      $argument = CalendarHelper::getDateArgumentHandler($this->view);

      return array(
        '#theme' => 'calendar_header',
        '#title' => $this->renderTextField($this->options['heading']),
        '#empty' => $empty,
        '#granularity' => $argument->getGranularity(),
      );
    }

    return array();
  }

  /**
   * Render a text area with \Drupal\Component\Utility\Xss::filterAdmin().
   */
  public function renderTextField($value) {
    if ($value) {
      return $this->sanitizeValue($this->tokenizeValue($value), 'xss_admin');
    }
    return '';
  }

}
