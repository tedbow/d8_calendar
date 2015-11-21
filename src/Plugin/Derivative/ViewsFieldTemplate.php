<?php
/**
 * @file
 * Contains \Drupal\calendar\Plugin\Derivative\ViewsFieldTemplate.
 */


namespace Drupal\calendar\Plugin\Derivative;


use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\views\ViewsData;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Derivative class to find all field and properties for calendar View Builders.
 */
class ViewsFieldTemplate implements  ContainerDeriverInterface{

  /**
   * List of derivative definitions.
   *
   * @var array
   */
  protected $derivatives = array();

  /**
   * The base plugin ID.
   *
   * @var string
   */
  protected $basePluginId;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The views data service.
   *
   * @var \Drupal\views\ViewsData
   */
  protected $viewsData;

  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static (
      $base_plugin_id,
      $container->get('entity.manager'),
      $container->get('views.views_data')
    );

  }

  /**
   * Constructs a ViewsBlock object.
   *
   * @param string $base_plugin_id
   *   The base plugin ID.
   * @param \Drupal\Core\Entity\EntityStorageInterface $view_storage
   *   The entity storage to load views.
   */
  public function __construct($base_plugin_id, EntityManagerInterface $manager, ViewsData $views_data) {
    $this->basePluginId = $base_plugin_id;
    $this->entityManager = $manager;
    $this->viewsData = $views_data;
  }


  public function getDerivativeDefinition($derivative_id, $base_plugin_definition) {
    if (!empty($this->derivatives) && !empty($this->derivatives[$derivative_id])) {
      return $this->derivatives[$derivative_id];
    }
    $this->getDerivativeDefinitions($base_plugin_definition);
    return $this->derivatives[$derivative_id];
  }

  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach ($this->entityManager->getDefinitions() as $entity_type_id => $entity_type) {
      // Just add support for entity types which have a views integration.
      if (($base_table = $entity_type->getBaseTable()) && $this->viewsData->get($base_table) && $this->entityManager->hasHandler($entity_type_id, 'view_builder')) {
        $entity_label = $entity_type->getLabel();
        $entity_views_data = $this->viewsData->get($base_table);

        foreach ($entity_views_data as $key => $field_info) {
          if ($this->isDateField($field_info)) {
            $field_info['table'] = $base_table;
            $this->setDerivative($field_info, $entity_type, $base_plugin_definition);

          }
        }
        if($data_table = $entity_type->getDataTable()) {
          $entity_data_views_data = $this->viewsData->get($data_table);
          foreach ($entity_data_views_data as $key => $field_info) {
            if ($this->isDateField($field_info)) {
              $field_info['table'] = $data_table;
              $this->setDerivative($field_info, $entity_type, $base_plugin_definition);

            }
          }
        }
        // @todo Loop through all fields attached to this entity type.
        // The have different base tables that are joined to this table.
      }
    }
    return $this->derivatives;
  }

  /**
   * @param array $field_info
   *  Field array form ViewsData.
   *
   * @return bool
   */
  protected function isDateField($field_info) {
    if (!empty($field_info['field']['id']) && $field_info['field']['id'] == 'field') {
      if (!empty($field_info['argument']['id']) && $field_info['argument']['id'] == 'date') {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * @param $field_info
   * @param $entity_type
   * @param $base_plugin_definition
   */
  protected function setDerivative($field_info, $entity_type, $base_plugin_definition) {
    /** @var \Drupal\Core\StringTranslation\TranslatableMarkup $field_title */
    $field_title = $field_info['title'];
    $entity_type_id = $entity_type->id();
    $field_id = $field_info['entity field'];
    $derivative_id = "$entity_type_id:$field_id";

    $this->derivatives[$derivative_id] = array(
      'id' => $base_plugin_definition['id'] . ':' . $derivative_id,
      'entity_label' => $entity_type->getLabel()->render(),
      'field_label' => $field_title->render(),
      'entity_type' => $entity_type_id,
      'field_id' => $field_id,
      'table' => $field_info['table'],
    ) + $base_plugin_definition;
  }


}
