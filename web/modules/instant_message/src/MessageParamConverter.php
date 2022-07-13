<?php

namespace Drupal\instant_message;

use Drupal\Core\Database\Connection;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

/**
 * Converts parameters for upcasting database record IDs to full std objects.
 *
 * @DCG
 * To use this converter specify parameter type in a relevant route as follows:
 * @code
 * instant_message.message_parameter_converter:
 *   path: example/{record}
 *   defaults:
 *     _controller: '\Drupal\instant_message\Controller\InstantMessageController::build'
 *   requirements:
 *     _access: 'TRUE'
 *   options:
 *     parameters:
 *       record:
 *        type: message
 * @endcode
 *
 * Note that for entities you can make use of existing parameter converter
 * provided by Drupal core.
 * @see \Drupal\Core\ParamConverter\EntityConverter
 */
class MessageParamConverter implements ParamConverterInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new MessageParamConverter.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The default database connection.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    // Return NULL if record not found to trigger 404 HTTP error.
    return $this->connection->query('SELECT * FROM {instant_message_example} WHERE mid = ?', [$value])->fetch() ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return !empty($definition['type']) && $definition['type'] == 'message';
  }

}
