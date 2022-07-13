<?php

namespace Drupal\instant_message\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Instant Message routes.
 */
class InstantMessageController extends ControllerBase {

  /**
   * @var \Drupal\Core\Database\Connection
   */
  private Connection $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('database'));
  }


  /**
   * Builds the response.
   */
  public function inbox() {

    $messages = $this->connection->select('instant_message_example')
      ->fields('instant_message_example', ['mid', 'from_uid', 'to_uid', 'read', 'subject', 'sent', 'body'])
      ->execute()
    ;

    $build['content'] = [
      '#theme' => 'instant_message.inbox',
      '#messages' => $messages,
    ];

    return $build;
  }

  public function show($message) {
    return [
      '#theme' => 'instant_message.show',
      '#message' => $message,
    ];
  }

}
