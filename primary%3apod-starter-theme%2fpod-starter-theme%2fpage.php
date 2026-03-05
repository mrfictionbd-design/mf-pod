<?php
/**
 * Generic page template
 *
 * @package POD_Starter_Pro
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
    <div class="container">

        <?php if (function_exists('pod_breadcrumbs')) pod_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>

            <article id="page-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>

                <?php if (!is_front_page()) : ?>
                    <header class="page-header text-center" style="padding-block: var(--space-xl);">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <?php if (has_post_thumbnail() && !is_front_page()) : ?>
                    <div class="page-featured-image mb-lg rounded-lg overflow-hidden">
                        <?php the_post_thumbnail('pod-hero', [
                            'class'   => 'w-full',
                            'loading' => 'eager',
                        ]); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages([
                        'before' => '<div class="page-links">' . __('Pages:', 'pod-starter'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="page-comments mt-xl">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();