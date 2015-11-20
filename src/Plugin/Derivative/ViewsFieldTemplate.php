<?php
/**
 * @file
 * Contains \Drupal\calendar\Plugin\Derivative\ViewsFieldTemplate.
 */


namespace Drupal\calendar\Plugin\Derivative;


use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\views\ViewsData;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Derivative class to find all field and properties for calendar View Builders.
 */
class ViewsFieldTemplate implements ContainerDeriverInterface {

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
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;

  /**
   * The views data service.
   *
   * @var \Drupal\views\ViewsData
   */
  protected $viewsData;

  /**
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $field_manager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static (
      $base_plugin_id,
      $container->get('entity_type.manager'),
      $container->get('views.views_data'),
      $container->get('entity_field.manager')
    );

  }

  /**
   * Constructs a ViewsBlock object.
   *
   * @param string $base_plugin_id
   *   The base plugin ID.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $manager
   * @param ViewsData $views_data
   *   The entity storage to load views.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $field_manager
   */
  public function __construct($base_plugin_id, EntityTypeManagerInterface $manager, ViewsData $views_data, EntityFieldManagerInterface $field_manager) {
    $this->basePluginId = $base_plugin_id;
    $this->entityManager = $manager;
    $this->viewsData = $views_data;
    $this->field_manager = $field_manager;
  }


  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinition($derivative_id, $base_plugin_definition) {
    if (!empty($this->derivatives) && !empty($this->derivatives[$derivative_id])) {
      return $this->derivatives[$derivative_id];
    }
    $this->getDerivativeDefinitions($base_plugin_definition);
    return $this->derivatives[$derivative_id];
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    /**
     * @var \Drupal\Core\Entity\EntityTypeInterface $entity_type
     */
    foreach ($this->entityManager->getDefinitions() as $entity_type_id => $entity_type) {
      // Just add support for entity types which have a views integration.
      if (($base_table = $entity_type->getBaseTable()) && $this->viewsData->get($base_table) && $this->entityManager->hasHandler($entity_type_id, 'view_builder')) {
        $entity_views_data = $this->viewsData->get($base_table);

        foreach ($entity_views_data as $key => $field_info) {
          if ($this->isDateField($field_info)) {
            $field_info['field_id'] = $field_info['entity field'];
            $field_info['base_table'] = $base_table;
            $field_info['base_field'] = $this->getTableBaseField($entity_views_data);
            $field_info['view_template_id'] = 'calendar_base_field';
            $this->setDerivative($field_info, $entity_type, $entity_views_data, $base_plugin_definition);

          }
        }
        if ($data_table = $entity_type->getDataTable()) {
          $entity_data_views_data = $this->viewsData->get($data_table);
          foreach ($entity_data_views_data as $key => $field_info) {
            if ($this->isDateField($field_info)) {
              $field_info['field_id'] = $field_info['entity field'];
              $field_info['base_table'] = $data_table;
              $field_info['base_field'] = $this->getTableBaseField($entity_data_views_data);
              $field_info['view_template_id'] = 'calendar_base_field';
              $this->setDerivative($field_info, $entity_type, $entity_data_views_data, $base_plugin_definition);

            }
          }
        }
        // @todo Loop through all fields attached to this entity type.
        // The have different base tables that are joined to this table.
        $this->setConfigurableFieldsDerivatives($entity_type, $base_plugin_definition);
      }

    }
    return $this->derivatives;
  }

  /**
   * Set all derivatives for an entity type.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   * @param array $base_plugin_definition
   */
  protected function setConfigurableFieldsDerivatives(EntityTypeInterface $entity_type, array $base_plugin_definition) {
    /** @var \Drupal\Core\Field\FieldStorageDefinitionInterface $field_storage */
    $field_storages = $this->field_manager->getFieldStorageDefinitions($entity_type->id());

    foreach ($field_storages as $field_id => $field_storage) {
      if ($field_storage->getType() == 'datetime') {
        // Find better way to get table name.
        $field_table_data = $this->viewsData->get($entity_type->id() . '__' . $field_id);

        if (isset($field_table_data[$field_id])) {
          $field_info = $field_table_data[$field_id];
          $field_info['field_id'] = $field_id;
          $join_tables = array_keys($field_table_data['table']['join']);
          // @todo Will there ever be more than 1 tables here?
          $join_table = array_pop($join_tables);
          $field_info['base_table'] = $join_table;
          $join_table_data = $this->viewsData->get($join_table);
          $field_info['default_field_id'] = $this->getTableDefaultField($join_table_data);
          $field_info['base_field'] = $this->getTableBaseField($join_table_data);
          $field_info['view_template_id'] = 'calendar_config_field';
          $this->setDerivative($field_info, $entity_type, $field_table_data, $base_plugin_definition);
        }

      }
    }
  }

  /**
   * Determine if a field is an date field.
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
   * Set the derivative for a field on an entity type.
   *
   * @param $field_info
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   * @param array $table_data
   * @param array $base_plugin_definition
   */
  protected function setDerivative($field_info, EntityTypeInterface $entity_type, array $table_data, array $base_plugin_definition) {
    /** @var \Drupal\Core\StringTranslation\TranslatableMarkup $field_title */
    $field_title = $field_info['title'];
    $entity_type_id = $entity_type->id();
    $field_id = $field_info['field_id'];
    $derivative_id = "$entity_type_id:$field_id";

    // Create base path
    if ($entity_type_id == 'node') {
      // For node use a shorter path.
      $base_path = "calendar-$field_id";
    }
    else {
      // For all other entity types include type in path
      $base_path = "calendar-$entity_type_id-$field_id";
    }

    $derivative = [
      'id' => $base_plugin_definition['id'] . ':' . $derivative_id,
      'entity_label' => $entity_type->getLabel(),
      'field_label' => $field_title,
      'entity_type' => $entity_type_id,
      'field_id' => $field_id,
      'table' => $field_info['base_table'],
      'base_table' => $field_info['base_table'],
      'view_template_id' => $field_info['view_template_id'],
        // @todo Find a better token system that works with both keys and values
        //  Make function prepareReplaceValuesArray
        // Create a replace key __FIELD_TABLE to avoid this __ENTITY_TYPE____FIELD_ID
      'replace_values' => [
        '__BASE_TABLE' => $field_info['base_table'],
        '__BASE_FIELD' => $field_info['base_field'],
        '__FIELD_ID' => $field_id,
        '__ENTITY_TYPE' => $entity_type_id,
        '__FIELD_LABEL' => $field_title,
        '__TABLE_LABEL' => $entity_type->getLabel(),
        '__BASE_PATH' => $base_path,

      ]
    ] + $base_plugin_definition;
    if (!empty($field_info['default_field_id'])) {
      $default_field_id = $field_info['default_field_id'];
    }
    else {
      $default_field_id = $this->getTableDefaultField($table_data);
      if (empty($default_field_id)) {
        // @todo Why doesn't user have a default field? Is there another way to get it?
        if ($entity_type_id == 'user') {
          $default_field_id = 'name';
        }
        else {
          // Setting to NULL will remove values from template if key is matched.
          $default_field_id = NULL;
        }
      }

    }
    $derivative['replace_values']['__DEFAULT_FIELD_ID'] = $default_field_id;

    // @todo Change permission in View to permission that associated with Entity Type.
    // @todo Change context from hardcoded 'user.node_grants:view'
    $this->derivatives[$derivative_id] = $derivative;
  }

  /**
   * Return the default field from a View table array.
   *
   * @param array $table_data
   *
   * @return null|string
   */
  private function getTableDefaultField(array $table_data) {
    if (!empty($table_data['table']['base']['defaults']['field'])) {
      return $table_data['table']['base']['defaults']['field'];
    }
    return NULL;
  }

  /**
   * Return the base field from a View tabel array.
   *
   * @param array $table_data
   *
   * @return null|string
   */
  private function getTableBaseField(array $table_data) {
    if (!empty($table_data['table']['base']['field'])) {
      return $table_data['table']['base']['field'];
    }
    return NULL;
  }


}
