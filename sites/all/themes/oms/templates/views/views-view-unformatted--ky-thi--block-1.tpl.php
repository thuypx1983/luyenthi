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
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
    <?php
    $result=$view->result[0];
    foreach($result->field_field_quiz as $item){
        $nid=$item['raw']['target_id'];
        $quiz=node_load($nid);
        ?>
      <div class="item col-md-3">
          <?php
          echo $quiz->title;
          ?>
      </div>
      <?php
    }
    ?>
  </div>
<?php endforeach; ?>
