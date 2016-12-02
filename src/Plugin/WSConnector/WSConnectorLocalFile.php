<?php

namespace Drupal\wsdata\Plugin\WSConnector;

use \Drupal\wsdata\Plugin;


/**
 * Local file connector.
 *
 * @WSConnector(
 *   id = "WSConnectorLocalFile",
 *   label = @Translation("Local file connector", context = "WSConnector"),
 * )
 */

class WSConnectorLocalFile extends \Drupal\wsdata\Plugin\WSConnectorBase {
  public function __construct($endpoint) {
    $this->languagePlugins = array(
      'replace',
    );
    parent::__construct($endpoint);
  }

  public function getMethods() {
    return array(
      'multiple' => array(
        'file' => t('File path'),
      ),
    );
  }

  public function wscall($type, $method, $argument, $options) {
    $filename = $this->endpoint . '/' . $method;
    if (!file_exists($filename)) {
      $this->setError(1, t("$filename does not exist."));
      return FALSE;
    }
    if (!is_readable($filename)) {
      $this->setError(1, t("$filename is not readable."));
      return FALSE;
    }
    return file_get_contents($filename);
  }
}
