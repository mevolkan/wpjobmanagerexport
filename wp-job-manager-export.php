<?php

/**
 * Plugin Name: WP Job Manager - Export
 * Plugin URI: brand2d.com
 * Description: Lets users export applications
 * Version: 1
 * Author: Volkan
 * Author URI: https://brand2d.com
 * Requires at least: 5.6
 * Tested up to: 5.8
 * Requires PHP: 7.0
 *
 * WPJM-Product: wp-job-manager-applications
 *
 * Copyright: 2022 Volkan
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function display_job_applications()
{
    $job_applications = new WP_Query(array(
        'post_type' => 'job_application',
        'post_status’' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'Full name'
            ),
            array(
                'key' => 'Email address'
            ),
            array(
                'key' => 'Phone'
            ),
            array(
                'key' => 'Gender'
            ),
            array(
                'key' => 'Age'
            ),
            array(
                'key' => 'CIC Employee'
            ),
            array(
                'key' => 'Message'
            ),
            array(
                'key' => '_job_applied_for'
            )
        )
    ));
    if ($job_applications->have_posts()) : ?>

        <?php while ($job_applications->have_posts()) : $job_applications->the_post(); ?>
            <article id="post-<?php the_ID(); ?>">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail(get_the_ID(), 'full');
                    } ?>
                    <?php
                    the_title();
                    the_content();
                    $meta_print_value = get_post_meta(get_the_ID(), '_job_applied_for', true);
                    echo ($meta_print_value);
                    ?>

                </a>
                <div class="post-category">
                    <?php the_category(', '); ?>
                </div>
                <div class="post-excerpt">
                    <?php wp_kses_post(the_excerpt()) ?>
                </div>
                <a itemprop="url" href="<?php the_permalink(); ?>" target="_blank">
                    <?php echo esc_html__('Read more', 'theme-domain') ?>
                </a>
            </article>
        <?php endwhile; ?>

    <?php else : ?>
        <p class="no-blog-posts">
            <?php esc_html_e('Sorry, no posts matched your criteria.', 'theme-domain'); ?>
        </p>
<?php endif;
    wp_reset_postdata();
}
function job_export_menu()
{
    add_menu_page(
        'Export Applications',
        'Export Applications',
        'manage_options',
        'export-applications',
        'display_job_applications'
    );
}
add_action('admin_menu', 'job_export_menu');
