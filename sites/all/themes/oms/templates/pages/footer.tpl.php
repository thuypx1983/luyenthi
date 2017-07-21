
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
<div id="footer-bottom">
  <div class="container">
    <div class="row">
      <?php print render($page['footer']) ?>
    </div>
  </div>
</div>