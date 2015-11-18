<?php
/**
 * @file
 * Contains
 * \Drupal\calendar\Plugin\ViewsTemplateBuilder\FieldTemplate.
 */


namespace Drupal\calendar\Plugin\ViewsTemplateBuilder;


use Drupal\Core\Form\FormStateInterface;
use Drupal\views_templates\Plugin\ViewsDuplicateBuilderBase;

/**
 * Views Template for all calendar fields.
 *
 * @Plugin(
 *  id = "calendar_field",
 *  view_template_id = "calendar_field",
 *  module = "calendar",
 *  deriver = "Drupal\calendar\Plugin\Derivative\ViewsFieldTemplate"
 * )
 */
class ViewsFieldTemplate extends ViewsDuplicateBuilderBase {


}
