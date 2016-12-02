<?php

namespace Drupal\wsdata\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Web Service Call entity.
 *
 * @ConfigEntityType(
 *   id = "wscall",
 *   label = @Translation("Web Service Call"),
 *   handlers = {
 *     "list_builder" = "Drupal\wsdata\WSCallListBuilder",
 *     "view_builder" = "Drupal\wsdata\WSCallViewBuilder",
 *     "form" = {
 *       "add" = "Drupal\wsdata\Form\WSCallForm",
 *       "edit" = "Drupal\wsdata\Form\WSCallForm",
 *       "delete" = "Drupal\wsdata\Form\WSCallDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\wsdata\WSCallHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "wscall",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/wscall/{wscall}",
 *     "add-form" = "/admin/structure/wscall/add",
 *     "edit-form" = "/admin/structure/wscall/{wscall}/edit",
 *     "delete-form" = "/admin/structure/wscall/{wscall}/delete",
 *     "collection" = "/admin/structure/wscall"
 *   }
 * )
 */
class WSCall extends ConfigEntityBase implements WSCallInterface {
  /**
   * The Web Service Call ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Web Service Call label.
   *
   * @var string
   */
  protected $label;

  public  $settings;
  public  $types;
  public  $wsserver;
  public  $wsparser;

  public function __construct(array $values, $entity_type) {
    parent::__construct($values, $entity_type);

  	$this->wsserverInst = entity_load('wsserver', $this->wsserver);
  	
  	$this->wsparserManager = \Drupal::service('plugin.manager.wsparser');
  }

  public function setEndpoint($endpoint) {
  	$this->wsserverInst->setEndpoint($endpoint);
  }

  public function getEndpoint() {
  	return $this->wsserverInst->getEndpoint();
  }
  
  public function getLanguagePlugin() {}
  public function call($type, $key = NULL, $replacement = array(), $argument = array(), $options = array(), &$method = '') {}
  public function getMethod($type, $replacement = array()) {}
  public function getReplacements($type) {}
  public function getOperations() {}
  public function getPossibleMethods() {}
}
