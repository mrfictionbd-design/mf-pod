<?php
/**
 * Category Grid template part
 *
 * @package POD_Starter_Pro
 */

if ( ! function_exists( 'wc_get_product_category_list' ) ) return;

$categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'number'     => get_theme_mod( 'pod_category_count', 6 ),
    'parent'     => 0,
) );

if ( empty( $categories ) || is_wp_error( $categories ) ) return;
?>

<section class="category-grid-section section-padding" id="categories">
    <div class="container">
        <div class="section-header text-center" data-animate>
            <h2><?php echo esc_html( get_theme_mod( 'pod_category_title', __( 'Shop by Category', 'pod-starter' ) ) ); ?></h2>
            <p><?php echo esc_html( get_theme_mod( 'pod_category_subtitle', __( 'Find the perfect product for your design', 'pod-starter' ) ) ); ?></p>
        </div>
        <div class="category-grid" data-animate>
            <?php foreach ( $categories as $category ) :
                $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                $image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/assets/images/hero-placeholder.jpg';
                $cat_url      = get_term_link( $category );
            ?>
            <a href="<?php echo esc_url( $cat_url ); ?>" class="category-card" data-animate>
                <div class="category-card__image">
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy">
                </div>
                <div class="category-card__content">
                    <h3 class="category-card__name"><?php echo esc_html( $category->name ); ?></h3>
                    <span class="category-card__count"><?php printf( _n( '%s Product', '%s Products', $category->count, 'pod-starter' ), $category->count ); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
