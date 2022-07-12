<?php

namespace Drupal\formation1\Controller;

use Drupal\Core\Controller\ControllerBase;

class Formation1Controller extends ControllerBase {

  public function action1()
  {
    return [
      '#theme' => 'formation1-exemple1',
      '#var2' => '<p>la partie "header"</p>',
    ];
  }
}
