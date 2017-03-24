<?php

namespace Drupal\wsdata\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Web Service Call entities.
 */
interface WSCallInterface extends ConfigEntityInterface {
  public function setEndpoint($endpoint);
  public function getEndpoint();
  public function getLanguagePlugin();
  public function call($type, $key = NULL, $replacement = array(), $argument = array(), $options = array(), &$method = '');
  public function getReplacements($type, $replacement = array());
  public function getMethods();
  public function getOptionsForm();
  public function setOptions($options);
  public function getOptions();
}
