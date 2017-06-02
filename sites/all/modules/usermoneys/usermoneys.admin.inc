<?php

/**
 * Form builder for add/edit usermoneys transaction form.
 */
function usermoneys_admin_txn($form, &$form_state, $mode, $txn = NULL) {

  //drupal_add_css(drupal_get_path('module', 'userpoints') . '/userpoints.css');

  $timestamp = format_date(REQUEST_TIME, 'custom', 'Y-m-d H:i O');
  if ($mode == 'edit') {
    drupal_set_title(t('Edit !moneys transaction'));
    $timestamp = format_date($txn->time_stamp, 'custom', 'Y-m-d H:i:s O');
    $txn_user = $txn->user;

    $form['txn'] = array(
      '#type' => 'value',
      '#value' => $txn,
    );
  }
  elseif ($mode == 'add') {
    drupal_set_title(t('Add !points', userpoints_translation()));
    if ($txn) {
      $txn_user = user_load($txn);
    }
  }
  $form['txn_user'] = array(
    '#type' => 'textfield',
    '#title' => t('User Name'),
    '#size' => 30,
    '#maxlength' => 60,
    '#default_value' => isset($txn_user) ? $txn_user->name : '',
    '#autocomplete_path' => $mode == 'edit' ? NULL : 'user/autocomplete',
    '#description' => t('The name of the user who should gain or lose !points.', userpoints_translation()),
    '#required' => TRUE,
    '#weight' => -20,
    '#disabled' => $mode == 'edit',
  );

  $form['points'] = array(
    '#type' => 'textfield',
    '#title' => t('Points'),
    '#size' => 10,
    '#maxlength' => 10,
    '#default_value' => isset($txn->points) ? $txn->points : 0,
    '#description' => t('The number of !points to add or subtract.  For example, enter %positive to add !points or %negative to deduct !points.', array('%positive' => 25, '%negative' => -25) + userpoints_translation()),
    '#required' => TRUE,
    '#weight' => -15,
  );

  if (module_exists('taxonomy')) {
    $options = userpoints_get_categories();
    $form['tid'] = array(
      '#type' => 'select',
      '#title' => t('Category'),
      '#default_value' => isset($txn->tid) ? $txn->tid : userpoints_get_default_tid(),
      '#options' => $options,
      '#description' => t('The !points category that should apply to this transaction.', userpoints_translation()),
      '#weight' => 0,
      // Only show the category if there are actually categories to choose from.
      '#access' => count($options) > 1,
    );
  }

  $form['additional_settings'] = array(
    '#type' => 'vertical_tabs',
  );

  $form['status'] = array(
    '#type' => 'fieldset',
    '#title' => t('Status'),
    '#group' => 'additional_settings',
  );

  if ($mode == 'add') {
    $form['status']['moderate'] = array(
      '#title' => t('Moderated'),
      '#type' => 'checkbox',
      '#description' => t('If checked, this !points transaction must be approved, through the moderation process.', userpoints_translation()),
      '#default_value' => variable_get(USERPOINTS_POINTS_MODERATION, 0),
      '#access' => userpoints_admin_access('moderate'),
      '#weight' => -10,
    );
  }
  else {
    $form['status']['status'] = array(
      '#title' => t('Approval status'),
      '#type' => 'radios',
      '#options' => userpoints_txn_status(),
      '#description' => t('Approval status of the transaction.'),
      '#default_value' => $txn->status,
      '#access' => userpoints_admin_access('moderate'),
      '#weight' => -10,
    );
  }

  $form['status']['time_stamp'] = array(
    '#type' => 'textfield',
    '#title' => t('Date/Time'),
    '#default_value' => $timestamp,
    '#size' => 30,
    '#maxlength' => 30,
    '#description' => t('The date and time recorded for this transaction. Use this format: YYYY-MM-DD HH:MM +ZZZZ.'),
    '#weight' => -5,
    // Do not show this if it is not allowed to change the timestamp anyway.
    '#access' => !variable_get(USERPOINTS_TRANSACTION_TIMESTAMP, 1),
  );

  $expirydate = 0;
  if (isset($txn->txn_id)) {
    if ($txn->expirydate > 0) {
      $expirydate = format_date($txn->expirydate, 'custom', 'Y-m-d H:i:s O');
    }
  }
  else {
    // If we're not editing we use site defaults.
    $expirydate = userpoints_get_default_expiry_date();
    if ($expirydate) {
      $expirydate = format_date($expirydate, 'custom', 'Y-m-d H:i:s O');
    }
  }
  $form['status']['expirydate'] = array(
    '#type' => 'textfield',
    '#title' => t('Expiration date'),
    '#default_value' => $expirydate ? $expirydate : '',
    '#size' => 30,
    '#maxlength' => 30,
    '#description' => t('The date and time that the !points should expire. Use this format: YYYY-MM-DD HH:MM +ZZZZ. Leave this field blank if the !points should never expire.', userpoints_translation()),
    '#weight' => 25,
  );

  $form['reason'] = array(
    '#type' => 'fieldset',
    '#title' => t('Reason'),
    '#group' => 'additional_settings',
  );

  $form['reason']['operation'] = array(
    '#type' => 'textfield',
    '#title' => t('Operation'),
    '#default_value' => isset($txn->operation) ? $txn->operation : t('admin'),
    '#maxlength' => 48,
    '#description' => t('The operation type for this transaction (default is %admin). Any value is valid but using a defined operation will cause an auto-generated description (specific to the chosen operation) to be included. This description can be translated into multiple languages.', array('%admin' => t('admin'))),
    '#weight' => 5,
    '#required' => FALSE,
    '#autocomplete_path' => 'userpoints/operation-autocomplete',
  );

  $form['reason']['description'] = array(
    '#type' => 'textarea',
    '#title' => t('Description'),
    '#default_value' => isset($txn->description) ? $txn->description : '',
    '#rows' => 7,
    '#cols' => 40,
    '#description' => t('Enter an optional description for this transaction, such as the reason !points were added or subtracted.', userpoints_translation()),
    '#weight' => 10,
  );

  $form['reference'] = array(
    '#type' => 'fieldset',
    '#title' => t('Reference'),
    '#group' => 'additional_settings',
  );

  $options = array('' => '< ' . t('None') . ' >');
  foreach (entity_get_info() as $type => $info) {
    $options[$type] = $info['label'];
  }
  $form['reference']['entity_type'] = array(
    '#type' => 'select',
    '#title' => t('Linked entity'),
    '#weight' => 0,
    '#options' => $options,
    '#default_value' => isset($txn->entity_type) ? $txn->entity_type : '',
  );

  $form['reference']['entity_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Entity ID'),
    '#title_display' => 'invisible',
    '#weight' => 5,
    '#size' => 5,
    '#maxlength' => 20,
    '#default_value' => isset($txn->entity_id) ? $txn->entity_id : '',
    '#description' => t('Choose the entity type and ID to be referenced. A link to the entity will be shown.'),
  );

  $form['reference']['reference'] = array(
    '#type' => 'textfield',
    '#title' => t('Internal reference'),
    '#default_value' => isset($txn->reference) ? $txn->reference : '',
    '#size' => 30,
    '#maxlength' => 128,
    '#description' => t('Enter an optional reference code for this transaction. This is for internal tracking and is not shown to the end user.', userpoints_translation()),
    '#weight' => 10,
  );

  $approved_by = !empty($txn->approver_uid) ? user_load($txn->approver_uid) : NULL;
  if ($approved_by) {
    $form['status']['approver'] = array(
      '#type' => 'textfield',
      '#title' => t('Moderator'),
      '#default_value' => $approved_by->name,
      '#size' => 30,
      '#maxlength' => 30,
      '#description' => t('The user who gave the transaction its current status.'),
      '#weight' => 30,
    );
  }

  $form['mode'] = array(
    '#type' => 'hidden',
    '#default_value' => $mode
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#weight' => 50,
  );
  return $form;
}