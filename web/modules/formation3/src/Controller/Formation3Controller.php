<?php

namespace Drupal\formation3\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Formation 3 routes.
 */
class Formation3Controller extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    /** @var \Drupal\Core\Database\Connection $connection */
    $connection = \Drupal::service('database');

    $result = $connection->select('formation3_example')
      ->fields('formation3_example', ['id', 'uid', 'type', 'status', 'created'])
      ->condition('status', 1)
      ->execute()
    ;

    $output = 'Texte example par défaut';
    foreach ($result as $row) {
      $output = date('d/m/Y', $row->created);
    }

    dpm($output);

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $output,
    ];

    return $build;
  }

}
