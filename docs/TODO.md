# TODO

- [ ] Implement wsconnectors:
  - [ ] REST Connector
- [ ] Port the Drush support and commands from D7 version.
- [ ] Write DrupalConsole integration for 3 plugin types
- [ ] Add caching support
- [ ] Implement sub-modules with specific suport:
  - [ ] wsdata_block
  - [ ] wsdata_extras
  - [ ] wsdata_field
  - [ ] wsdata_rules
- [ ] Better header Control
  - [ ] Implement the header options for the wscall and wsconnectors.

## WSData Fields Implementation Plan

### Overview

In D7, field storage was handled seperately from entity storage. Per the follow pseudo code:

function Entity Load ($id) {
  StubEntity = Entity Storage Controller -> Load ($id)  // Load the stub entity with no field data.
  foreach (field configured on the entity type of StubEntity) {
    Field->Field Storage Controller -> Load (StubEntity) // Load the data for each field on at a time, from potentially different backends.
  }
}

In D8, the entity storage controller controls loading both the entity and field data from the backend (SQL).
So a replacements field storage controller cannot be written as in the D7 implementation.

Field Storage entity do have an option "custom_storage".  When set to TRUE (default is FALSE), the field/entity controller will not load or save data in that field.

The suggested entry point to set data on entity with fields having custom_storage set to TRUE appears to only be:

hook_entity_storage_load or hook_entity_load.

Since data attached to an entity in hook_entity_storage will be cached, wsfields must inject data into entities view hook_entity_load().

### Caveats

This might be a blocker: https://www.drupal.org/node/2695527

Search API will need to be tested with fields where "custom_storage" is set to TRUE to make sure this isn't an issue.

### Components that need implementing

- [ ] Add a UI element to the field storage configuration page to:
  - [ ] Set custom_storage to TRUE on that field storage entity
  - [ ] Allow the user to choose a WSCall
  - [ ] Allow the user to set a which value they need returned from the WSCall result
  - [ ] Select replacement tokens to be sent to the WSCall
- [ ] Figure out where the above settings can be storage (either in the field storage entity [preferred] or else where).
- [ ] Implement hook_entity_load that:
  - [ ] Checks if the entity being load have wsdata fields
  - [ ] Loads the WSData service.
  - [ ] Call the correct WSCalls with configured replacements and such via the WSData service
  - [ ] Injects the resulting data into the entities.

