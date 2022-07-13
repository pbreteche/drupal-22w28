<?php

namespace Drupal\formation3\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Formation 3 form.
 */
class ExampleForm extends FormBase {
  const TYPE_STANDARD = 'standard';
  const TYPE_PREMIUM = 'premium';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'formation3_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Is active'),
    ];

    $form['type'] = [
      '#type' => 'select',
      '#options' => [
        self::TYPE_STANDARD => $this->t(self::TYPE_STANDARD),
        self::TYPE_PREMIUM => $this->t(self::TYPE_PREMIUM),
      ],
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!in_array($form_state->getValue('type'), [self::TYPE_STANDARD, self::TYPE_PREMIUM])) {
      $form_state->setErrorByName('type', $this->t('Type should have one of allowed values.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var Connection $connection */
    $connection = \Drupal::service('database');

    $connection->insert('formation3_example')
      ->fields([
        'uid' => \Drupal::currentUser()->id(),
        'status' => $form_state->getValue('status'),
        'type' => $form_state->getValue('type'),
        'created' => time(),
      ])
      ->execute()
    ;
  }
}
