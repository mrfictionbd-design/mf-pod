<?php
/**
 * Single post template
 *
 * @package POD_Starter_Pro
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
    <div class="container">

        <?php if (function_exists('pod_breadcrumbs')) pod_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

                <header class="single-post__header text-center" style="padding-block: var(--space-xl); max-width: 800px; margin-inline: auto;">
                    <!-- Categories -->
                    <div class="single-post__categories mb-sm">
                        <?php
                        $categories = get_the_category();
                        if ($categories) {
                            foreach ($categories as $cat) {
                                printf(
                                    '<a href="%s" class="product-card__badge product-card__badge--new" style="text-decoration:none;">%s</a> ',
                                    esc_url(get_category_link($cat->term_id)),
                                    esc_html($cat->name)
                                );
                            }
                        }
                        ?>
                    </div>

                    <h1 class="single-post__title"><?php the_title(); ?></h1>

                    <div class="single-post__meta flex flex--center flex--gap-md mt-md" style="color: var(--color-gray-500); font-size: var(--font-size-sm);">
                        <!-- Author -->
                        <div class="flex flex--center" style="gap: var(--space-2xs);">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', ['class' => 'rounded-full']); ?>
                            <span><?php the_author(); ?></span>
                        </div>

                        <span>·</span>

                        <!-- Date -->
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>

                        <span>·</span>

                        <!-- Reading Time -->
                        <span>
                            <?php
                            $content = get_the_content();
                            $word_count = str_word_count(wp_strip_all_tags($content));
                            $reading_time = max(1, ceil($word_count / 250));
                            printf(
                                esc_html(_n('%d min read', '%d min read', $reading_time, 'pod-starter')),
                                $reading_time
                            );
                            ?>
                        </span>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-post__image mb-xl rounded-lg overflow-hidden" style="max-width: 1000px; margin-inline: auto;">
                        <?php the_post_thumbnail('pod-hero', [
                            'class'   => 'w-full',
                            'loading' => 'eager',
                        ]); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content" style="max-width: 768px; margin-inline: auto;">
                    <?php
                    the_content();

                    wp_link_pages([
                        'before' => '<div class="page-links flex flex--center flex--gap-sm mt-lg">' . __('Pages:', 'pod-starter'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>

                <!-- Tags -->
                <?php
                $tags = get_the_tags();
                if ($tags) : ?>
                    <div class="single-post__tags flex flex--wrap flex--gap-sm mt-xl" style="max-width: 768px; margin-inline: auto;">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                               class="chatbot-quick-reply"
                               style="text-decoration: none;">
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Author Box -->
                <div class="single-post__author-box flex flex--gap-md mt-xl rounded-lg" style="max-width: 768px; margin-inline: auto; background: var(--color-gray-50); padding: var(--space-lg); border-radius: var(--radius-lg);">
                    <div style="flex-shrink: 0;">
                        <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', ['class' => 'rounded-full']); ?>
                    </div>
                    <div>
                        <h4 style="margin-bottom: var(--space-3xs);">
                            <?php the_author(); ?>
                        </h4>
                        <p style="color: var(--color-gray-600); font-size: var(--font-size-sm); margin-bottom: var(--space-xs);">
                            <?php echo esc_html(get_the_author_meta('description')); ?>
                        </p>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="btn btn--sm btn--ghost">
                            <?php esc_html_e('View all posts →', 'pod-starter'); ?>
                        </a>
                    </div>
                </div>

                <!-- Post Navigation -->
                <nav class="single-post__nav grid grid--2 mt-xl" style="max-width: 768px; margin-inline: auto; gap: var(--space-md);" aria-label="<?php esc_attr_e('Post navigation', 'pod-starter'); ?>">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();

                    if ($prev_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="product-card" style="text-decoration: none; padding: var(--space-md);">
                            <small style="color: var(--color-gray-500);">← <?php esc_html_e('Previous', 'pod-starter'); ?></small>
                            <h4 style="font-size: var(--font-size-sm); margin-top: var(--space-3xs);">
                                <?php echo esc_html($prev_post->post_title); ?>
                            </h4>
                        </a>
                    <?php else : ?>
                        <div></div>
                    <?php endif;

                    if ($next_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="product-card" style="text-decoration: none; padding: var(--space-md); text-align: right;">
                            <small style="color: var(--color-gray-500);"><?php esc_html_e('Next', 'pod-starter'); ?> →</small>
                            <h4 style="font-size: var(--font-size-sm); margin-top: var(--space-3xs);">
                                <?php echo esc_html($next_post->post_title); ?>
                            </h4>
                        </a>
                    <?php endif; ?>
                </nav>

            </article>

            <!-- Related Posts -->
            <?php
            $related = new WP_Query([
                'category__in'   => wp_get_post_categories($post->ID),
                'posts_per_page' => 3,
                'post__not_in'   => [$post->ID],
            ]);

            if ($related->have_posts()) : ?>
                <section class="related-posts mt-xl" style="max-width: 1000px; margin-inline: auto;">
                    <h3 class="text-center mb-lg"><?php esc_html_e('Related Articles', 'pod-starter'); ?></h3>
                    <div class="grid grid--3">
                        <?php while ($related->have_posts()) : $related->the_post(); ?>
                            <article class="product-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="product-card__image-wrapper" style="aspect-ratio: 16/10;">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('pod-product-card', [
                                                'class'   => 'product-card__image',
                                                'loading' => 'lazy',
                                            ]); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="product-card__body">
                                    <h4 class="product-card__title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <p style="color: var(--color-gray-500); font-size: var(--font-size-xs);">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </p>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </section>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

            <!-- Comments -->
            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="single-post__comments mt-xl" style="max-width: 768px; margin-inline: auto;">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();