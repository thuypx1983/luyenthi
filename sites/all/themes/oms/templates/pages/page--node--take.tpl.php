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


  <div class="container">
    <?php print $messages; ?>
  </div>

  <?php if (theme_get_setting('show_front_content') == 1): ?>
    <div id="main" class="container">
      <?php if ($breadcrumb): ?>
        <div id="breadcrumb"><?php print $breadcrumb; ?></div>
      <?php endif; ?>

      <div class="row">
        <section class="col-md-8" id="post-content" role="main">
          <div class="main-quiz-take">
            <?php if ($page['content_top']): ?><div id="content_top"><?php print render($page['content_top']); ?></div><?php endif; ?>

            <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
            <?php print render($page['help']); ?>
            <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
            <h1 class="page-title"><?php echo $title?></h1>
            <?php print render($page['content']); ?>
          </div>
        </section> <!-- /#main -->

        <aside id="sidebar" role="complementary" class="sidebar col-md-4">
          <div class="table-question">
            <div class="title">
              <span>Bảng câu hỏi</span>
            </div>
            <div class="guide">
              <span><i class="fa fa-square answered"></i> Đã trả lời</span>
              <span><i class="fa fa-square un-answer"></i> Chưa trả lời</span>
              <span><i class="fa fa-square remember"></i> Cần xem lại</span>
            </div>
            <div class="question-list">

            </div>
            <div class="clearfix"></div>
            <div class="timer">
              <div class="countdown"></div>
            </div>
            <div class="clearfix"></div>
          </div>
          <script type="text/javascript">
              (function($){
                  $(function(){
                    var html="";
                    var i=1;
                    $('.quiz-question-multichoice').each(function(){
                      var nid=($(this).attr('id').replace('edit-question-',''));
                      html+='<div class="item-question" data-i="'+i+'" style="float:left">' +
                          '<a class="qnbutton" id="quiznavbutton'+i+'" title="Chưa trả lời" data-quiz-page="'+nid+'" href="#edit-question-'+nid+'">' +

                          i+'</a>' +
                          '</div>';
                      i++;
                        $(this).find('table tbody').append('<tr><td colspan="2"><span data-nid='+nid+' class="need-review"><i class="fa fa-flag-o"></i>Cần xem lại</span></td></tr>')
                    })
                    $('.question-list').append(html);

                    $('.quiz-question-multichoice .multichoice-row').click(function () {
                      var input=$(this).find('input[type=radio]');
                      var nid=input.attr('name').replace('question[','').replace('][answer][user_answer]','');
                      $('.question-list').find('a[data-quiz-page='+nid+']').addClass('answered');
                    })

                    $('.quiz-question-multichoice').each(function () {
                      var flag=false;

                      $(this).find('input[type=radio]').each(function () {
                        if($(this).is( ":checked" )){
                          flag=true;
                        }
                      })
                      if(flag){
                        var nid=$(this).attr('id').replace('edit-question-','');
                        $('.question-list').find('a[data-quiz-page='+nid+']').addClass('answered');
                      }

                    })

                      $('.quiz-question-multichoice').on('click','.need-review',function(){
                          var nid=$(this).attr('data-nid');
                          var buttomStatus=$('.question-list').find('[data-quiz-page='+nid+']');
                          if($(this).hasClass('checked')){
                              $(this).removeClass('checked');
                              buttomStatus.removeClass('need-review')
                          }else{
                              $(this).addClass('checked');
                              buttomStatus.addClass('need-review');
                          }
                      })




                      var offset = $("#sidebar").offset();
                      var topPadding = 15;

                      $(window).scroll(function() {

                          if ($(window).scrollTop() > offset.top) {

                              $("#sidebar").stop().animate({

                                  marginTop: $(window).scrollTop() - offset.top + topPadding

                              });

                          } else {

                              $("#sidebar").stop().animate({

                                  marginTop: 0

                              });

                          }


                      });
                  })
              })(jQuery)
          </script>
        </aside>
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