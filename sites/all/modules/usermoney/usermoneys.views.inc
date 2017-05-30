<?php


/**
 *  @file
 *  This defines views hooks for the UserMoneys module. It will be loaded automatically as needed by the Views module.
 */

/**
 * Implements hook_views_data().
 */
function usermoneys_views_data() {
  // ----------------------------------------------------------------
  // userMoneys table
  // Describe the userMoneys table.
  // Define the base group of this table. Fields that don't
  // have a group defined will go into this field by default.
  $data['usermoneys']['table']['group'] = t('Usermoneys');

  $data['usermoneys']['table']['base'] = array(
      'field' => 'uid',
      'title' => t('usermoneys'),
      'help' => t('Moneys by category accumulated by users on your site.'),
  );

  $data['usermoneys']['table']['join'] = array(
      'users' => array(
          'left_field' => 'uid',
          'field' => 'uid',
      ),
      'node' => array(
          'left_field' => 'uid',
          'field' => 'uid',
      )
  );

  // Describe the Moneys column of the userMoneys table.
  $data['usermoneys']['moneys'] = array(
      'title' => t('Current !Moneys in category'),
      'help' => t("A User's current !Moneys in a single category."), // The help that appears on the UI,
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
          'numeric' => TRUE,
          'name field' => 'moneys', // display this field in the summary
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );

  // Describe the last_update column of the userMoneys table.
  $data['usermoneys']['last_update'] = array(
      'title' => t('Last update in category'),
      'help' => t("The last update timestamp for a User's current !Moneys in a single category."),
      'field' => array(
          'handler' => 'views_handler_field_date',
          'click sortable' => TRUE,
      ),
      'sort' => array(
          'handler' => 'views_handler_sort_date',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_date',
      ),
  );

  // Add relationship to user table.
  $data['usermoneys']['uid'] = array(
      'title' => t('User'),
      'help' => t('Relate the userMoneys table to the user table.'),
      'relationship' => array(
          'base' => 'users',
          'field' => 'uid',
          'label' => t('Users'),
          'handler' => 'views_handler_relationship',
      ),
  );

  return $data;
}
