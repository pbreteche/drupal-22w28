<?php

namespace Drupal\formation2\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Formation 2 settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'formation2_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['formation2.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['reference_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Reference date'),
      '#default_value' => $this->config('formation2.settings')->get('reference_date'),
    ];
    $form['default_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Default name'),
      '#default_value' => $this->config('formation2.settings')->get('default_name'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $inputDate = new \DateTime($form_state->getValue('reference_date'));
    if ($inputDate < new \DateTime()) {
      $form_state->setErrorByName('reference_date', $this->t('Reference date should not be in past.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('formation2.settings')
      ->set('reference_date', $form_state->getValue('reference_date'))
      ->set('default_name', $form_state->getValue('default_name'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
