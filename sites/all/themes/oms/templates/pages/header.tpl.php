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

<div class="container">
  <?php print $messages; ?>
</div>