<?php

namespace Drupal\instant_message\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an Instant Message form.
 */
class ComposeForm extends FormBase {

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
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'instant_message_composer';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['to'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#title' => $this->t('Recipient'),
      '#required' => TRUE,
      '#selection_handler' => 'default:user',
      '#selection_settings' => [
        'include_anonymous' => FALSE,
        'type' => 'permissions',
        'filter' => [
          'permissions' => ['access instant_message'],
        ],
      ],
    ];

    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subject'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
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
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->connection->insert('instant_message_example')
      ->fields([
        'from_uid' => \Drupal::currentUser()->id(),
        'to_uid' => $form_state->getValue('to'),
        'subject' => $form_state->getValue('subject'),
        'body' => $form_state->getValue('message'),
        'sent' => time(),
        'read' => 0
      ])->execute();

    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('instant_message.inbox');
  }

}
