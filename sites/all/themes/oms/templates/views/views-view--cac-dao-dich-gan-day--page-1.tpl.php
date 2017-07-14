
<?php
global $user;
//$user=user_load($user->uid);
$user_profile=profile_view_field($user)?>
<div class="profile row"<?php print $attributes; ?>>

  <div class="col-md-3 profile-left">
    <div class="content">
      <div class="profile-left">
        <div class="profile-title">Thông tin tài khoản</div>
        <?php
        print render($user_profile['user_picture']);
        ?>
        <div class="name"><span><?php echo $field_name[0]['value']?></span></div>
      </div>
      <div class="user-tools">
        <ul>
          <li><a href="<?php echo url('user/'.$user->uid)?>">Thông tin cá nhân</a></li>
          <li><a href="<?php echo url('myuserpoints')?>">Điểm của tôi</a></li>
          <li><a href="<?php echo url('user/paycard-history')?>">Lịch sử nạp thẻ</a></li>
          <li><a href="<?php echo url('user/payment-transaction')?>">Lịch sử giao dịch</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-9 profile-left">
    <div class="profile-title">Thông tin cá nhân</div>

    <div class="<?php print $classes; ?>">
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <?php print $title; ?>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php if ($header): ?>
        <div class="view-header">
          <?php print $header; ?>
        </div>
      <?php endif; ?>

      <?php if ($exposed): ?>
        <div class="view-filters">
          <?php print $exposed; ?>
        </div>
      <?php endif; ?>

      <?php if ($attachment_before): ?>
        <div class="attachment attachment-before">
          <?php print $attachment_before; ?>
        </div>
      <?php endif; ?>

      <?php if ($rows): ?>
        <div class="view-content">
          <?php print $rows; ?>
        </div>
      <?php elseif ($empty): ?>
        <div class="view-empty">
          <?php print $empty; ?>
        </div>
      <?php endif; ?>

      <?php if ($pager): ?>
        <?php print $pager; ?>
      <?php endif; ?>

      <?php if ($attachment_after): ?>
        <div class="attachment attachment-after">
          <?php print $attachment_after; ?>
        </div>
      <?php endif; ?>

      <?php if ($more): ?>
        <?php print $more; ?>
      <?php endif; ?>

      <?php if ($footer): ?>
        <div class="view-footer">
          <?php print $footer; ?>
        </div>
      <?php endif; ?>

      <?php if ($feed_icon): ?>
        <div class="feed-icon">
          <?php print $feed_icon; ?>
        </div>
      <?php endif; ?>

    </div><?php /* class view */ ?>

  </div>
</div>