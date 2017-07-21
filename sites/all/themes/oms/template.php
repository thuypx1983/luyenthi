<?php
/**
 * Implements hook_html_head_alter().
 * This will overwrite the default meta character type tag with HTML5 version.
 */
function oms_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function oms_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Use CSS to hide titile .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // comment below line to hide current page to breadcrumb
	$breadcrumb[] = drupal_get_title();
    $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';
    return $output;
  }
}

function oms_preprocess_html(&$vars) {
    global $user;
    foreach ($user->roles as $role){
        $vars['classes_array'][]=strtolower(str_replace(' ','-',$role));
    }
}

/**
 * Override or insert variables into the html template.
 */
function oms_process_html(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_html_alter($vars);
  }

}

/**
 * Override or insert variables into the page template.
 */
function oms_process_page(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }

  #edit template page node type
  if (!empty($variables['node']) && !empty($variables['node']->type)) {
    $variables['theme_hook_suggestions'][] = 'page__node__' . $variables['node']->type;
  }


}

/**
 * Override or insert variables into the page template.
 */
function oms_preprocess_page(&$vars) {

  //Add videojs api to header
  videojs_add();
  if (isset($vars['main_menu'])) {
    $vars['main_menu'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'main-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['main_menu'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_menu'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'secondary-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['secondary_menu'] = FALSE;
  }

  // Build footer_copyright variable to template.
  if (theme_get_setting('footer_copyright')) {
    if ($vars['site_name']) {
      $vars['footer_copyright'] = t('Copyright &copy; @year, @sitename.',
        array('@year' => date("Y"), '@sitename' => $vars['site_name'])
      );
    }
    else {
      $vars['footer_copyright'] = t('Copyright &copy; @year.',
        array('@year' => date("Y"), '@sitename' => $vars['site_name'])
      );
    }
  }
  else {
    $vars['footer_copyright'] = NULL;
  }

    if ($vars['is_front']) {
        $vars['title'] = null;
        unset($vars['page']['content']['system_main']);
    }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function oms_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function oms_preprocess_node(&$variables) {
  global $user;
  $node = $variables['node'];

  if(!in_array('administrator',$user->roles)){
    $field_price= field_get_items('node',$node,'field_price');
    if($field_price){
      if($field_price[0]['value']>0){
        if(!course_access_check($node->nid,$user->uid)){
          drupal_goto('payments/course/'.$node->nid.'/buy');
          drupal_exit();
        }
      }
    }
  }


  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Add javascript files for front-page jquery slideshow.
 */
if (drupal_is_front_page()) {
  //drupal_add_js(drupal_get_path('theme', 'oms') . '/js/sliding_effect.js');
}



function oms_form_alter( &$form, &$form_state,$form_id ){
    // this is for your developer information and shows you the
    // structure of the form array


}

/**
 * @param $variables
 * hook_preprocess_menu_link
 */
function oms_preprocess_menu_link(&$variables) {
    if(isset($variables['element']['#localized_options']['content']['image'])){
        $fid=$variables['element']['#localized_options']['content']['image'];
        $file = file_load($fid);
        $icon='<img src="'.file_create_url($file->uri).'">';
        $variables['element']['#title']=$icon.'<span class="link-text">'.$variables['element']['#title'].'</span>';
    }
}

function oms_multichoice_answer_node_view($variables){
  $alternatives = $variables['alternatives'];
  $show_correct = $variables['show_correct'];
  $header = array('', '');

  foreach ($alternatives as $i => $short) {
    $answer_markup = check_markup($short['answer']['value'], $short['answer']['format']);
    // Find the is_correct status.
    $is_correct = ($short['score_if_chosen'] > $short['score_if_not_chosen']);
    $image = $is_correct ? 'correct' : 'wrong';
    if (!$show_correct) {
      $image = 'unknown';
    }

    $rows[] = array(
      array(
        'width' => 64,
        'data' => array(
          '#theme' => 'html_tag',
          '#tag' => 'span',
          '#attributes' => array(
            'class' => array(
              'quiz-score-icon',
              $image,
            ),
            'title' => $show_correct ?
              t('Score if chosen: @sc Score if not chosen: @nc', array(
                  '@sc' => $short['score_if_chosen'],
                  '@nc' => $short['score_if_not_chosen'])
              ) :
              t('You are not allowed to view the solution for this question'),
          ),
        ),
      ),
      $answer_markup
    );
  }
  return theme('table', array('header' => $header, 'rows' => $rows));
}

function oms_quiz_answer_result($variables){
  $options = array();
  $type = $variables['type'];

  switch($type) {
    case 'correct':
      $options['path'] = 'check_008000_64.png';
      $options['alt'] = t('Correct');
      $options['markup']='<i class="fa fa-check answered-correct"></i>';
      break;
    case 'incorrect':
      $options['path'] = 'times_ff0000_64.png';
      $options['alt'] = t('Incorrect');
      $options['markup']='<i class="fa fa-close answered-wrong"></i>';
      break;
    case 'unknown':
      $options['path'] = 'question_808080_64.png';
      $options['alt'] = t('Unknown');
      $options['markup']='<i class="fa fa-question"></i>';
      break;
    case 'should':
      $options['path'] = 'check_808080_64.png';
      $options['alt'] = t('Should have chosen');
      $options['markup']='<i class="fa fa-check"></i>';
      break;
    case 'should-not':
      $options['path'] = 'times_808080_64.png';
      $options['alt'] = t('Should not have chosen');
      $options['markup']='<i class="fa fa-close"></i>';
      break;
    case 'almost':
      $options['path'] = 'check_ffff00_64.png';
      $options['alt'] = t('Almost');
      break;
    case 'selected':
      $options['path'] = 'arrow-right_808080_64.png';
      $options['alt'] = t('Selected');
      $options['markup']='<i class="fa fa-check"></i>';
      break;
    case 'unselected':
      $options['path'] = 'circle-o_808080_64.png';
      $options['alt'] = t('Unselected');
      $options['markup']='<i class="fa fa-circle-o"></i>';
      break;
    default:
      $options['path'] = '';
      $options['alt'] = '';
      $options['markup']='<i class="fa fa-question"></i>';
  }

  /*if (!empty($options['path'])) {
    $options['path'] = drupal_get_path('module', 'quiz') . '/images/' . $options['path'];
  }
  if (!empty($options['alt'])) {
    $options['title'] = $options['alt'];
  }

  $image = theme('image', $options);*/
  return '<div class="quiz-score-icon ' . $type . '">' . $options['markup'] . '</div>';

}

function oms_field_views_data($field) {
  $x=1;
}