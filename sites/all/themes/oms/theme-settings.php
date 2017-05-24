<?php
/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function oms_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['busi_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('OMS Theme Settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['busi_settings']['show_front_content'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show content and sidebar on front page'),
    '#default_value' => theme_get_setting('show_front_content','oms'),
    '#description' => t('Check this option to show content and sidebar on the front page.'),
  );
  $form['busi_settings']['breadcrumbs'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show breadcrumbs in a page'),
    '#default_value' => theme_get_setting('breadcrumbs','oms'),
    '#description'   => t("Check this option to show breadcrumbs in page. Uncheck to hide."),
  );

  $form['busi_settings']['footer'] = array(
    '#type' => 'fieldset',
    '#title' => t('Footer'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['busi_settings']['footer']['footer_copyright'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show copyright text in footer'),
    '#default_value' => theme_get_setting('footer_copyright','oms'),
    '#description'   => t("Check this option to show copyright text in footer. Uncheck to hide."),
  );
  $form['busi_settings']['footer']['footer_credits'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show theme credits in footer'),
    '#default_value' => theme_get_setting('footer_credits','oms'),
    '#description'   => t("Check this option to show copyright text in footer. Uncheck to hide."),
  );
}
