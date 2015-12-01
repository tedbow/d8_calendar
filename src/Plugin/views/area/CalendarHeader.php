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
 * Views area Calendar Header area.
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
    //$options['tokenize']['default'] = TRUE;
    //$options['empty']['default'] = TRUE;
    // Provide our own default.
    $options['content'] = array('default' => '');
    $options['pager_embed'] = array('default' => FALSE);
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['content'] = array(
      '#title' => $this->t('Heading'),
      '#type' => 'textarea',
      '#default_value' => $this->options['content'],
      '#rows' => 6,
    );
    $form['pager_embed'] = array(
      '#title' => $this->t('Use Pager'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['pager_embed'],
    );

  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {

      $argument = CalendarHelper::getDateArgumentHandler($this->view);

      $render = [];
      $header_text = $this->renderTextArea($this->options['content']);

      if (!$this->options['pager_embed']) {
        $render = array(
          '#theme' => 'calendar_header',
          '#title' => $header_text,
          '#empty' => $empty,
          '#granularity' => $argument->getGranularity(),
        );
      }
      else {
        if ($this->view->display_handler->renderPager()) {
          $exposed_input = isset($this->view->exposed_raw_input) ? $this->view->exposed_raw_input : NULL;
          $render = $this->view->renderPager($exposed_input);
          // Override the exclude option of the pager.
          $render['#exclude'] = FALSE;
          $render['#items']['current'] = $header_text;
        }
      }
      return $render;

    }

    return array();
  }

  /**
   * Render a text area with \Drupal\Component\Utility\Xss::filterAdmin().
   */
  public function renderTextArea($value) {
    if ($value) {
      return $this->sanitizeValue($this->tokenizeValue($value), 'xss_admin');
    }
    return '';
  }

}
