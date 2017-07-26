<?php

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */
?>
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
                   <li class="active"><a href="<?php echo url('user/1')?>"><?php echo t('Thông tin cá nhân')?></a></li>
                   <li><a href="<?php echo url('myuserpoints')?>"><?php echo t('Điểm của tôi')?></a></li>
                   <li><a href="<?php echo url('user/paycard-history')?>"><?php echo t('Lịch sử nạp thẻ')?></a></li>
                   <li><a href="<?php echo url('user/payment-transaction')?>"><?php echo t('Lịch sử giao dịch')?></a></li>
               </ul>
           </div>
       </div>
    </div>
    <div class="col-md-9 profile-left">
        <div class="profile-title">Thông tin cá nhân</div>
      <?php
      print render($user_profile['field_name']);
      print render($user_profile['field_birthday']);
      print render($user_profile['field_phone']);
      print render($user_profile['field_province']);
      print render($user_profile['field_school']);
      print render($user_profile['summary']);
      ?>
  </div>
</div>
