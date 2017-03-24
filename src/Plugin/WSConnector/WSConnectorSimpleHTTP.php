<?php

namespace Drupal\wsdata\Plugin\WSConnector;

use \Drupal\wsdata\Plugin;

/**
 * HTTP Connector.
 *
 * @WSConnector(
 *   id = "WSConnectorSimpleHTTP",
 *   label = @Translation("Simple HTTP connector", context = "WSConnector"),
 * )
 */

class WSConnectorSimpleHTTP extends \Drupal\wsdata\Plugin\WSConnectorBase {

  public function getMethods() {
    return array('call');
  }

  public function getOptions() {
    return array(
      'path' => NULL,
      'method' => array(),
    );
  }

  public function getOptionsForm() {
    return array(
      'path' => array(
        '#title' => t('Path'),
        '#description' => t('The final endpoint will be <em>Server Endpoint/Path</em>'),
        '#type' => 'textfield',
      ),
      'method' => array(
        '#title' => t('HTTP Method'),
        '#type' => 'select',
        '#options' => array(
          'get' => 'GET',
          'post' => 'POST',
          'put' => 'PUT',
          'delete' => 'DELETE',
          'head' => 'HEAD',
          'options' => 'OPTIONS',
        ),
      ),
    );
  }

  public function call($options, $method, $replacements = [], $data = NULL) {
    return NULL;
  }

}
