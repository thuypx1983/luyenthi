<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
    <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="row">
    <div class="col-md-6 left">
<?php
$i=1;
foreach ($rows as $id => $row): ?>
  <?php
    if($i==1){
     ?>
        <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
          <?php print $row; ?>
        </div>
        </div>
        <div class="col-md-6 right">
      <?php
    } else{
      ?>
        <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
          <?php print $row; ?>
        </div>
    <?php
    }
      ?>

  <?php
  $i++;
endforeach;
?>
        </div>
</div>
