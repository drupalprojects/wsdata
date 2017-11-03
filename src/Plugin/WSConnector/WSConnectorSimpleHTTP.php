<?php

namespace Drupal\wsdata\Plugin\WSConnector;

use Drupal\Core\Utility\Token;
use Drupal\wsdata\WSDataInvalidMethodException;
use Drupal\wsdata\Plugin\WSConnectorBase;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * HTTP Connector.
 *
 * @WSConnector(
 *   id = "WSConnectorSimpleHTTP",
 *   label = @Translation("Simple HTTP connector", context = "WSConnector"),
 * )
 */
class WSConnectorSimpleHTTP extends WSConnectorBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(
         array $configuration,
         $plugin_id,
         $plugin_definition,
         Client $http_client,
         Token $token
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $token);
    $this->http_client = $http_client;
    $this->token = $token;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('http_client'),
      $container->get('token')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getMethods() {
    return ['get', 'post', 'put', 'delete', 'head', 'options'];
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions() {
    return [
      'path' => NULL,
      'method' => [],
      'headers' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function saveOptions($values) {
    $token_service = \Drupal::token();
    // Fix the headers values.
    $values['headers'] = array($values['key'] => $token_service->replace($values['value']));
    return parent::saveOptions($values);
  }

  /**
   * {@inheritdoc}
   */
  public function getReplacements(array $options) {
    return $this->findTokens($this->endpoint . '/' . $options['path']);
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsForm() {
    $methods = $this->getMethods();
    $form['path'] = [
      '#title' => t('Path'),
      '#description' => t('The final endpoint will be <em>Server Endpoint/Path</em>'),
      '#type' => 'textfield',
      '#maxlength' => 512,
    ];

    $form['method'] = [
      '#title' => t('HTTP Method'),
      '#type' => 'select',
      '#options' => array_combine($methods, $methods),
    ];

    $form['headers'] = [
      '#type' => 'container',
    ];

    for($i = 0; $i < 1; $i++) {
      $form['headers'][$i]['key'] = [
        '#type' => 'textfield',
        '#title' => t('Key'),
      ];

      $form['headers'][$i]['value'] = [
        '#type' => 'textfield',
        '#title' => t('Value'),
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function call($options, $method, $replacements = [], $data = NULL, array $tokens = []) {
    if (!in_array($method, $this->getMethods())) {
      throw new WSDataInvalidMethodException(sprintf('Invalid method %s on connector type %s', $method, __CLASS__));
    }

    $uri = $this->endpoint . '/' . $options['path'];
    $uri = $this->applyReplacements($uri, $replacements, $tokens);
    $options['http_errors'] = FALSE;

    if (!empty($data)) {
      $options['body'] = $data;
    }

    $response = $this->http_client->request($method, $uri, $options);
    $status = $response->getStatusCode();

    if ($status >= 199 and $status <= 300) {
      return (string)$response->getBody();
    }

    $this->setError($status, $response->getReasonPhrase());
    return FALSE;
  }
}
