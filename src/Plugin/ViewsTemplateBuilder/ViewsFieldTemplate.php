<?php
/**
 * @file
 * Contains
 * \Drupal\calendar\Plugin\ViewsTemplateBuilder\FieldTemplate.
 */


namespace Drupal\calendar\Plugin\ViewsTemplateBuilder;


use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\views_templates\Plugin\ViewsDuplicateBuilderBase;
use Drupal\views_templates\ViewsTemplateLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Views Template for all calendar fields.
 *
 * @ViewsBuilder(
 *  id = "calendar_field",
 *  view_template_id = "calendar_field",
 *  module = "calendar",
 *  deriver = "Drupal\calendar\Plugin\Derivative\ViewsFieldTemplate"
 * )
 */
class ViewsFieldTemplate extends ViewsDuplicateBuilderBase {

  /**
   * @var  \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $field_manager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ViewsTemplateLoaderInterface $loader, EntityFieldManagerInterface $manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $loader);
    $this->field_manager = $manager;

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('views_templates.loader'),
      $container->get('entity_field.manager')
    );
  }

  protected function alterViewTemplateAfterCreation(array &$view_template, $options = NULL) {
    parent::alterViewTemplateAfterCreation($view_template, $options);
    $field_defs = $this->field_manager->getBaseFieldDefinitions($this->getDefinitionValue('entity_type'));
    if (empty($field_defs['status'])) {
      // If entity doesn't have a base field status remove it from View filter.
      unset($view_template['display']['default']['display_options']['filters']['status']);
    }
  }


}
