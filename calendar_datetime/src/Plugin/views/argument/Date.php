<?php

/**
 * @file
 * Contains \Drupal\calendar_datetime\Plugin\views\argument\Date.
 */

namespace Drupal\calendar_datetime\Plugin\views\argument;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Plugin\views\argument\Formula;
use Drupal\views\Plugin\views\Argument\Date as CoreDate;

/**
 * Abstract argument handler for dates.
 *
 * Adds an option to set a default argument based on the current date.
 *
 * Definitions terms:
 * - many to one: If true, the "many to one" helper will be used.
 * - invalid input: A string to give to the user for obviously invalid input.
 *                  This is deprecated in favor of argument validators.
 *
 * @see \Drupal\views\ManyTonOneHelper
 *
 * @ingroup views_argument_handlers
 *
 * @ViewsArgument("calendar_date")
 */
class Date extends CoreDate implements ContainerFactoryPluginInterface {

  /**
   * The date format used in the title.
   *
   * @var string
   */
  protected $format;

  /**
   * The default date format used in the query.
   *
   * @var string
   */
  protected $argFormat = 'Y-m-d';

  /**
   * {@inheritdoc}
   */
  public function getSortName() {
    return $this->t('Date', array(), array('context' => 'Sort order'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormula() {
    $this->formula = $this->getDateFormat($this->argFormat);
    return parent::getFormula();
  }

  /**
   * Returns the date format used in the query in a form usable by PHP.
   *
   * @return string
   *   The date format used in the query.
   */
  public function getArgFormat() {
    return $this->argFormat;
  }
}
