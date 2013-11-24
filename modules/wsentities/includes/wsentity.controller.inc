<?php

/**
 * @file
 * Provides a controller building upon the core controller but providing more
 * features like full CRUD functionality.
 */

/**
 * Interface for WSEntityControllers compatible with the entity API.
 */
interfaceWSEntityAPIControllerInterface extends EntityAPIControllerInterface {

  /**
   * Load single entity
   *
   * Web services which don't offer an index method will instead load entities using
   * multiple loadSingle() calls.
   *
   * Also a single object call to a web services can be cached on the remote end more
   * easily than a group of arbitrary entities.
   */
  public function loadSingle($id);

  /**
   * Validate that the entity supports the given operation
   *
   * @param string $op
   *  Operation as defined in the wsconfig
   *
   * @return boolean
   *  Returns TRUE if the operation is available, FALSE otherwise.
   */
  public function hasOperation($op);
}

/**
 * WSEntityAPIController extends and overrides most EntityAPIController features
 **/
class WSEntityAPIControllerimplementsWSEntityAPIControllerInterface {
  protected $wsconfig;

  /**
   * Constructor.
   *
   * @param $entityType
   *   The entity type for which the instance is created.
   */
  public function __construct($entityType) {
    if (empty($this->wsconfig)) {
      $this->wsconfig = wsconfig_load_by_name($this->entityInfo['wsconfig']);
    }
  }

  /**
   * Resets the internal, static entity cache.
   *
   * @param $ids
   *   (optional) If specified, the cache is reset for the entities with the
   *   given ids only.
   */
  public function resetCache(array$ids = NULL) {
    // @todo
  }

  /**
   * Loads one or more entities.
   *
   * @param $ids
   *   An array of entity IDs, or FALSE to load all entities.
   * @param $conditions
   *   An array of conditions in the form 'field' => $value.
   *
   * @return
   *   An array of entity objects indexed by their ids. When no results are
   *   found, an empty array is returned.
   */
  public function load($ids = array(), $conditions = array()) {
    $entities = array();

    if ($this->entityInfo['wsentity']['load single'] or count($ids) == 1) {
      foreach ($ids as $id) {
        $entity = $this->loadSingle($id);
        // Check if the load was successfull
        if (FALSE !== $entity) {
          $entities[] = $entity;
        }
      }
    }
    else {
      // @todo
    }

    return $entities;
  }

  /**
   * Loads a single entity
   *
   * @param mixed $id
   *  Entity Id
   *
   * @return object
   *  Returns an entity object, FALSE otherwise.
   */
  public function loadSingle($id) {
    // @todo make wsconfig call
    return FALSE;
  }

  /**
   * Delete permanently saved entities.
   *
   * In case of failures, an exception is thrown.
   *
   * @param $ids
   *   An array of entity IDs.
   */
  public function delete($ids) {
    // @todo
  }

  /**
   * Invokes a hook on behalf of the entity. For hooks that have a respective
   * field API attacher like insert/update/.. the attacher is called too.
   */
  public function invoke($hook, $entity) {
    // @todo
  }

  /**
   * Permanently saves the given entity.
   *
   * In case of failures, an exception is thrown.
   *
   * @param $entity
   *   The entity to save.
   *
   * @return
   *   SAVED_NEW or SAVED_UPDATED is returned depending on the operation
   *   performed.
   */
  public function save($entity) {
    // @todo
  }

  /**
   * Create a new entity.
   *
   * @param array $values
   *   An array of values to set, keyed by property name.
   *
   * @return
   *   A new instance of the entity type.
   */
  public function create(array$values = array()) {
    // @todo
  }

  /**
   * Exports an entity as serialized string.
   *
   * @param $entity
   *   The entity to export.
   * @param $prefix
   *   An optional prefix for each line.
   *
   * @return
   *   The exported entity as serialized string. The format is determined by
   *   the controller and has to be compatible with the format that is accepted
   *   by the import() method.
   */
  public function export($entity, $prefix = '') {
    // @todo
  }

  /**
   * Imports an entity from a string.
   *
   * @param string $export
   *   An exported entity as serialized string.
   *
   * @return
   *   An entity object not yet saved.
   */
  public function import($export) {
    // @todo
  }

  /**
   * Builds a structured array representing the entity's content.
   *
   * The content built for the entity will vary depending on the $view_mode
   * parameter.
   *
   * @param $entity
   *   An entity object.
   * @param $view_mode
   *   View mode, e.g. 'full', 'teaser'...
   * @param $langcode
   *   (optional) A language code to use for rendering. Defaults to the global
   *   content language of the current request.
   *
   * @return
   *   The renderable array.
   */
  public function buildContent($entity, $view_mode = 'full', $langcode = NULL) {
    // @todo
  }

  /**
   * Generate an array for rendering the given entities.
   *
   * @param $entities
   *   An array of entities to render.
   * @param $view_mode
   *   View mode, e.g. 'full', 'teaser'...
   * @param $langcode
   *   (optional) A language code to use for rendering. Defaults to the global
   *   content language of the current request.
   * @param $page
   *   (optional) If set will control if the entity is rendered: if TRUE
   *   the entity will be rendered without its title, so that it can be embeded
   *   in another context. If FALSE the entity will be displayed with its title
   *   in a mode suitable for lists.
   *   If unset, the page mode will be enabled if the current path is the URI
   *   of the entity, as returned by entity_uri().
   *   This parameter is only supported for entities which controller is a
   *   EntityAPIControllerInterface.
   *
   * @return
   *   The renderable array, keyed by entity name or numeric id.
   */
  public function view($entities, $view_mode = 'full', $langcode = NULL, $page = NULL) {
    // @todo
  }

  /**
   * Validate that the entity supports the given operation
   *
   * @param string $op
   *  Operation as defined in the wsconfig
   *    Ex: load, update, insert, delete, index
   *
   * @return boolean
   *  Returns TRUE if the operation is available, FALSE otherwise.
   */
  public function hasOperation($op) {
    $ops = $this->wsconfig->getOperations();
    return in_array($op, $ops);
  }
}

