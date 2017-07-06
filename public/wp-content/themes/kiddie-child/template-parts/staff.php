<?php
/**
 * Kiddie staff template part
 *
 * @package Kiddie
 */
$paged = get_query_var('paged', 1);
$args = array(
  'post_type' => 'kiddie_staff',
  'nopaging' => true
);

$query = new WP_Query($args);

if ($query->have_posts())
  {
  while ($query->have_posts())
    {
    $query->the_post();
?>
          <div class="<?php kiddie_bc('3', '3'); ?>">
              <div class="ztl-staff-item">
                    <div class="image" style="border-color: <?php
                        if (get_post_meta(get_the_ID() , 'kiddie_staff_color', true))
                          {
                            echo esc_attr(get_post_meta(get_the_ID() , 'kiddie_staff_color', true));
                          }
                          else
                          {
                            echo '#ffd823';
                          } ?>">
                          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php
                            if (has_post_thumbnail())
                              {
                              the_post_thumbnail('kiddie-square-big');
                              }
                            ?>
                          </a>
                        <div class="staff-excerpt"><?php the_excerpt(); ?></div>
                    </div>
               <center>
                  <div class="staff-title"><?php the_title(); ?></div>
                  <div class="staff-position"
                     style="color: <?php echo esc_attr(get_post_meta(get_the_ID() , 'kiddie_staff_color', true)); ?>;">
                    <?php echo esc_html(get_post_meta(get_the_ID() , 'kiddie_staff_position', true)); ?>
                  </div>
              </center>
            </div>
        </div>

        <?php
    }
  }
  else
  {
  get_template_part('content', 'none');
  } ?>
