<?php

namespace Drupal\wsdata\Plugin\WSConnector;

use Drupal\wsdata\Plugin\WSConnectorBase;

/**
 * REST Connector.
 *
 * @WSConnector(
 *   id = "WSConnectorREST",
 *   label = @Translation("RESTful Connector", context = "WSConnector"),
 * )
 */

class WSConnectorREST extends WSConnectorBase {
  public function getMethods() {
    return array('create', 'read', 'update', 'delete', 'index');
  }

  public function getOptions() {
    return array(
      'path' => NULL,
      'methods' => array(),
    );
  }

  public function getOptionsForm() {
    return array(
      'path' => array(
        '#title' => $this->t('Path'),
        '#description' => $this->t('The final endpoint will be <em>Server Endpoint/Path</em>'),
        '#type' => 'textfield',
      ),
      'methods' => array(
        '#title' => $this->t('Supported Operations'),
        '#type' => 'checkboxes',
        '#options' => array(
          'create' => t('RESTful create method (POST to <em>Endpoint/Path</em>)'),
          'read' => t('RESTful read method (GET to <em>Endpoint/Path/ID</em>)'),
          'update' => t('RESTful update method (PUT to <em>Endpoint/Path/ID</em>)'),
          'delete' => t('RESTful delete method (DELETE to <em>Endpoint/Path/ID</em>)'),
          'index' => t('RESTful index method (GET to <em>Endpoint/Path</em>)'),
        ),
      ),
    );
  }

  public function call($options, $method, $replacements = [], $data = NULL) {
    return NULL;
  }
}
