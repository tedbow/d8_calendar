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
 *  deriver = "Drupal\calendar\Plugin\Derivative\ViewsFieldTemplate"
 * )
 */
class ViewsFieldTemplate extends ViewsDuplicateBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function alterViewTemplateAfterCreation(&$view_template, $options) {
    // @todo Recursively loop through $view_template and
    // replace all keys and values that start with "__" with values from plugin definition.
  }


  public function getAdminLabel() {
    return $this->t("@entity_type @field Calendar",
      [
        '@entity_type' => $this->getDefinitionValue('entity_label'),
        '@field' => $this->getDefinitionValue('field_label'),
      ]
    );
  }

  public function getDescription() {
    return $this->t("A calendar view of the '@field' field in the '@table' base table",
      [
        '@table' => $this->getDefinitionValue('table'),
        '@field' => $this->getDefinitionValue('field_label'),
      ]
    );
  }


}
