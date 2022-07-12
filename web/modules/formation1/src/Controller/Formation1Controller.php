<?php

namespace Drupal\formation1\Controller;

use Drupal\Core\Controller\ControllerBase;

class Formation1Controller extends ControllerBase {

  public function action1()
  {
    return [
      'header' => [
        '#type' => 'item',
        '#markup' => '<p>la partie "header"</p>',
      ],
      'body' => [
        '#type' => 'item',
        '#markup' => '<p>la partie "body"</p>',
      ]
    ];
  }
}
