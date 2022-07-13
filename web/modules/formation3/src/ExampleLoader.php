<?php

namespace Drupal\formation3;

use Drupal\Core\Database\Connection;

/**
 * Service description.
 */
class ExampleLoader {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs an ExampleLoader object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * Method description.
   */
  public function load(int $maxElement = null) {
    $query = $this->connection->select('formation3_example')
      ->fields('formation3_example', ['id', 'uid', 'type', 'status', 'created'])
      ->condition('status', 1)
    ;
    if ($maxElement) {
      $query->range(0, $maxElement);
    }

    return $query->execute();
  }

}
