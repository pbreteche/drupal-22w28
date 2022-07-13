<?php

namespace Drupal\instant_message\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Instant Message settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'instant_message_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['instant_message.settings'];
  }



  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['read_retention'] = [
      '#type' => 'number',
      '#title' => $this->t('Read retention'),
      '#default_value' => $this->config('instant_message.settings')->get('read_retention'),
      '#description' => $this->t('Define number of days')
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('read_retention') <= 0) {
      $form_state->setErrorByName('read_retention', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('instant_message.settings')
      ->set('read_retention', $form_state->getValue('read_retention'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
