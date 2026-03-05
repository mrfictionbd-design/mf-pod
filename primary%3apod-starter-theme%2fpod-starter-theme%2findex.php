<?php
/**
 * The main template file
 *
 * @package POD_Starter_Pro
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid grid grid--auto-fit">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-card__image-wrapper">
                                <?php the_post_thumbnail('pod-product-card', [
                                    'class'   => 'product-card__image',
                                    'loading' => 'lazy',
                                ]); ?>
                            </div>
                        <?php endif; ?>

                        <div class="product-card__body">
                            <h2 class="product-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="product-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination mt-xl">
                <?php the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '← ' . __('Previous', 'pod-starter'),
                    'next_text' => __('Next', 'pod-starter') . ' →',
                ]); ?>
            </div>

        <?php else : ?>
            <div class="no-results text-center py-xl">
                <h2><?php esc_html_e('Nothing found', 'pod-starter'); ?></h2>
                <p><?php esc_html_e('Try searching for something else.', 'pod-starter'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();