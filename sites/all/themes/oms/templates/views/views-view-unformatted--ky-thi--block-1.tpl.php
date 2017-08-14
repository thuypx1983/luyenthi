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

      <div class="row">
        <?php print $row; ?>
        <?php
        $result=$view->result[0];
        foreach($result->field_field_quiz as $item){
            $nid=$item['raw']['target_id'];
            $quiz=node_load($nid);
            ?>
            <div class="item col-md-3 col-xs-6 col-sm-6">
                <?php
                $field_subject=field_get_items('node',$quiz,'field_subject');
                if($field_subject){
                    $term=taxonomy_term_load($field_subject[0]['tid']);
                    $image=field_view_field('taxonomy_term', $term, 'field_image', array('label'=>'hidden'));
                    ?>
                    <a href="<?php echo url('node/'.$quiz->nid)?>" class="subject-btn <?php echo str_replace(' ','-',transliteration_clean_filename($term->name))?>">
                        <div class="subject-image"><?php print  render($image); ?></div>
                        <div class="subject-name"><?php echo $term->name?></div>
                    </a>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>

      </div>
  </div>
<?php endforeach; ?>
