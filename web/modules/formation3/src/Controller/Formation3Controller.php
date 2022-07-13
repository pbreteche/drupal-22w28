<?php

namespace Drupal\formation3\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\formation3\ExampleLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Formation 3 routes.
 */
class Formation3Controller extends ControllerBase {

  /**
   * @var \Drupal\formation3\ExampleLoader
   */
  private ExampleLoader $loader;

  public function __construct(ExampleLoader $loader) {
    $this->loader = $loader;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('formation3.example_loader')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    $result = $this->loader->load();

    $output = 'Texte example par défaut';
    foreach ($result as $row) {
      $output = date('d/m/Y', $row->created);
    }

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $output,
    ];

    return $build;
  }

}
