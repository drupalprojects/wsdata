<?php

namespace Drupal\wsdata\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Web Service Server entities.
 */
interface WSServerInterface extends ConfigEntityInterface {
  public function getEnabledLanguagePlugin();
  public function setEndpoint($endpoint);
  public function getEndpoint();
  public function disable($degraded = FALSE);
  public function enable($degraded = FALSE);
  public function isDisabled();
  public function getDegraded();
}
