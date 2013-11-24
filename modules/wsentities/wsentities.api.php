<?php

/**
 * @file
 * Sample API documentation for WSEntities
 */

/**
 * Define a new remote entity type.
 */
function hook_entity_info() {
  /**
   * WSEntities can be used with most of the basic options in 
   * hook_entity_info().
   *
   * Note that wsconfig and wsconfig_type entities cannot use the WSEntityAPIController 
   *
   * It also introduces a few new options. You can add these to your info array by 
   * calling wsentities_add_entity_info();
   *
   * @see wsentities_add_entity_info().
   */

  // Add the new options. Will return FALSE if invalid options are set.
  // If the options were invalid, your info array remains unchanged.
  $valid = wsentities_add_entity_info($info, 'wsconfig_machine_name');

  $info = array(
    '...',
    'wsentity' => array(
      'controller class' => 'WSEntityAPIController', // Required. Entity controller designed for use with web services.
      'wsconfig' => 'wsconfig_machine_name', // Required. Name of the wsconfig instance responsible for all data operations for this entity type.
      'cache-control' => TRUE, // Optional. Whether to respect the cache-control headers returned
      'cache-control-expiry' => 3600, // Optional. If cache-control is set to FALSE, how long to cache items for.
      'load single' => TRUE, // Whether the controller should load entities in a single query (i.e. index, search) or multiple queries. Default TRUE.
    )
    '...',
  );
}

/**
 * Convert an existing entity into a remote entity
 */
function hook_entity_info_alter(&$info) {
  // You can apply the options using an alter as well
  $valid = wsentities_add_entity_info($info, 'wsconfig_machine_name');
}