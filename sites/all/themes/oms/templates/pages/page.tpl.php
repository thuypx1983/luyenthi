<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
?>

<div id="wrap">

  <header id="header" class="clearfix" role="banner">
    <div class="header-top container-out">
      <div class="container">
        <div class="row">
          <?php print render($page['header_top']); ?>
        </div>
      </div>
    </div>
    <div class="header">
      <div class="container">
        <div class="row">
          <?php print render($page['header']); ?>
        </div>

      </div>

    </div>
    <div class="container-out main-menu-container">
      <div class="container">
        <div class="main-menu">
          <!-- start main-menu -->
          <nav id="navigation" class="clearfix" role="navigation">
            <div id="main-menu">
              <?php
              if (module_exists('i18n_menu')) {
                $main_menu_tree = i18n_menu_translated_tree(variable_get('menu_main_links_source', 'main-menu'));
              } else {
                $main_menu_tree = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
              }
              print drupal_render($main_menu_tree);
              ?>
            </div>
          </nav><!-- end main-menu -->
        </div>
      </div>
    </div>
    <div class="container-out header-bottom">
      <div class="container">
        <div class="row">
          <?php print render($page['header_bottom']); ?>
        </div>
      </div>
    </div>
  </header>


  <?php print $messages; ?>

  <?php if ($page['homequotes']): ?>
    <div id="home-quote"> <?php print render($page['homequotes']); ?></div>
  <?php endif; ?>

  <?php if ($page['home_highlight_left'] || $page['home_highlight_right']): ?>
    <div id="home-highlights" class="clearfix">
      <div class="container">
        <div class="row">
          <?php if ($page['home_highlight_left']): ?>
            <div class="home-highlight-left col-md-9"><?php print render($page['home_highlight_left']); ?></div>
          <?php endif; ?>
          <?php if ($page['home_highlight_right']): ?>
            <div class="home-highlight-right col-md-3"><?php print render($page['home_highlight_right']); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if (theme_get_setting('show_front_content') == 1): ?>
    <div id="main" class="container">
      <?php if ($breadcrumb): ?>
        <div id="breadcrumb"><?php print $breadcrumb; ?></div>
      <?php endif; ?>

     <div class="row">
       <section class="<?php if($page['sidebar_first']) echo 'col-md-8'; else echo 'col-md-12';?>" id="post-content" role="main">
         <?php if ($page['content_top']): ?><div id="content_top"><?php print render($page['content_top']); ?></div><?php endif; ?>

         <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
         <?php print render($page['help']); ?>
         <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
         <h1 class="page-title"><?php echo $title?></h1>
         <?php print render($page['content']); ?>
       </section> <!-- /#main -->

       <?php if ($page['sidebar_first']): ?>
         <aside id="sidebar" role="complementary" class="sidebar col-md-4">
           <?php print render($page['sidebar_first']); ?>
         </aside>  <!-- /#sidebar-first -->
       <?php endif; ?>
     </div>
    </div>
    <div class="clear"></div>
  <?php endif; ?>

  <?php if ($page['footer_first'] || $page['footer_second'] || $page['footer_third'] || $page['footer_fourth']): ?>
    <div id="footer-saran" class=" clearfix">
      <div id="footer-wrap" class="container">
        <div class="row">
          <?php if ($page['footer_first']): ?>
            <div class="footer-box col-md-3"><?php print render($page['footer_first']); ?></div>
          <?php endif; ?>
          <?php if ($page['footer_second']): ?>
            <div class="footer-box col-md-3"><?php print render($page['footer_second']); ?></div>
          <?php endif; ?>
          <?php if ($page['footer_third']): ?>
            <div class="footer-box col-md-3"><?php print render($page['footer_third']); ?></div>
          <?php endif; ?>
          <?php if ($page['footer_fourth']): ?>
            <div class="footer-box remove-margin col-md-3"><?php print render($page['footer_fourth']); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  <?php endif; ?>

  <!--END footer -->
  <div id="footer-bottom">
    <div class="container">
      <div class="row">
        <?php print render($page['footer']) ?>
      </div>
    </div>
  </div>
</div>