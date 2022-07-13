<?php

namespace Drupal\formation3\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "formation3_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("Formation 3")
 * )
 */
class ExampleBlock extends BlockBase {

  public function defaultConfiguration() {
    return [
      'max elements' => 5,
    ];
  }

  public function blockForm($form, FormStateInterface $formState) {
    $config = $this->getConfiguration();

    $form['max_elements'] = [
      '#type' => 'number',
      '#title' => $this->t('Max elements'),
      '#default_value' => $config['max elements'],
    ];

    return $form;
  }

  public function blockValidate($form, FormStateInterface $form_state) {
    $maxElementsInput = $form_state->getValue('max_elements');
    if ($maxElementsInput <= 0) {
      $form_state->setErrorByName('max_elements', $this->t('Type value should greater than 0.'));
    }
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('max elements', $form_state->getValue('max_elements'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\Core\Database\Connection $connection */
    $connection = \Drupal::service('database');
    $config = $this->getConfiguration();

    $result = $connection->select('formation3_example')
      ->fields('formation3_example', ['id', 'uid', 'type', 'status', 'created'])
      ->condition('status', 1)
      ->range(0, $config['max elements'])
      ->execute()
    ;

    $items = [];

    foreach ($result as $row) {
      $items[] = $row->type;
    }

    $build['content'] = [
      '#theme' => 'item_list',
      '#items' => $items,
    ];
    return $build;
  }
}
