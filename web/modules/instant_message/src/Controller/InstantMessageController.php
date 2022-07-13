<?php

namespace Drupal\instant_message\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Instant Message routes.
 */
class InstantMessageController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function inbox() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
