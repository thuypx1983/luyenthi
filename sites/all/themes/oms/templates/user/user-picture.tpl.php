<?php

/**
 * @file
 * Default theme implementation to present a picture configured for the
 * user's account.
 *
 * Available variables:
 * - $user_picture: Image set by the user or the site's default. Will be linked
 *   depending on the viewer's permission to view the user's profile page.
 * - $account: Array of account information. Potentially unsafe. Be sure to
 *   check_plain() before use.
 *
 * @see template_preprocess_user_picture()
 *
 * @ingroup themeable
 */
?>
<?php if ($user_picture): ?>
  <div class="<?php print $classes; ?>">
    <?php print $user_picture; ?>
  </div>
<?php else:?>
    <div class="<?php print $classes; ?>">
      <a href="<?php global $user; echo url('user/'.$user->name)?>"><img src="/sites/default/files/styles/thumbnail/public/pictures/picture-1-1498807340.jpg?itok=nmxkER_x"></a>
    </div>
<?php endif; ?>
