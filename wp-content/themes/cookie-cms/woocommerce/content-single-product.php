<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

$args = apply_filters(
	'wc_price_args',
	wp_parse_args(
		$args,
		array(
			'ex_tax_label'       => false,
			'currency'           => '',
			'decimal_separator'  => wc_get_price_decimal_separator(),
			'thousand_separator' => wc_get_price_thousand_separator(),
			'decimals'           => wc_get_price_decimals(),
			'price_format'       => get_woocommerce_price_format(),
		)
	)
);

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$attachment_ids = $product->get_gallery_attachment_ids();
?>
<!-- Product DEtails Area Start -->
<div class="product-detials-area bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-5">
				<div class="product-image-slider d-flex flex-column">
					<!--Product Tab Content Start-->
					<div class="tab-content product-large-image-list">

						<div class="tab-pane fade show active" id="product-slide0" role="tabpanel" aria-labelledby="product-slide-tab-0">
							<div class="single-product-img easyzoom img-full">
								<a href="<?= wp_get_attachment_url(get_post_thumbnail_id()) ?>"><img src="<?= wp_get_attachment_url(get_post_thumbnail_id()) ?>" class="img-fluid" alt="<?= get_the_title(get_post_thumbnail_id()) ?>"></a>
							</div>
						</div>

						<?php
						if (!empty($attachment_ids)) :
							$number = 1;
							foreach ($attachment_ids as $attachment_id) {
								if ($number == 1) : ?>
									<div class="tab-pane fade" id="product-slide1" role="tabpanel" aria-labelledby="product-slide-tab-1">
										<div class="single-product-img easyzoom img-full">
											<a href="<?= wp_get_attachment_url($attachment_id) ?>"><img src="<?= wp_get_attachment_url($attachment_id) ?>" class="img-fluid" alt="<?= get_the_title($attachment_id) ?>"></a>
										</div>
									</div>

								<?php else : ?>
									<div class="tab-pane fade" id="product-slide<?= $number ?>" role="tabpanel" aria-labelledby="product-slide-tab-<?= $number ?>">
										<div class="single-product-img easyzoom img-full">
											<a href="<?= wp_get_attachment_url($attachment_id) ?>"><img src="<?= wp_get_attachment_url($attachment_id) ?>" class="img-fluid" alt="<?= get_the_title($attachment_id) ?>"></a>
										</div>
									</div>
						<?php
								endif;
								$number++;
							}
						endif; ?>
					</div>
					<!--Product Content End-->
					<!--Product Tab Menu Start-->
					<div class="product-small-image-list">
						<div class="nav small-image-slider-single-product-tabstyle-3" role="tablist">


							<div class="single-small-image img-full">
								<a data-toggle="tab" id="product-slide-tab-0" href="#product-slide0"><img src="<?= wp_get_attachment_url(get_post_thumbnail_id()) ?>" class="img-fluid" alt=""></a>
							</div>

							<?php
							if (!empty($attachment_ids)) :
								$number = 1;
								foreach ($attachment_ids as $attachment_id) { ?>
									<div class="single-small-image img-full">
										<a data-toggle="tab" id="product-slide-tab-<?= $number ?>" href="#product-slide<?= $number ?>"><img src="<?= wp_get_attachment_url($attachment_id) ?>" class="img-fluid" alt=""></a>
									</div>
							<?php
									$number++;
								}
							endif; ?>

						</div>
					</div>
					<!--Product Tab Menu End-->
				</div>
			</div>
			<div class="col-lg-7 col-md-7">
				<div class="product-details-text">
					<h3><?php the_title(); ?></h3>
					<div class="p-rating-review">
						<!-- <div class="product-rating">
							<i class="fa fa-star-o color"></i>
							<i class="fa fa-star-o color"></i>
							<i class="fa fa-star-o color"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
						</div>
						<a href="#" class="scroll-down">(2 customer reviews)</a> -->
						<?php
						/**
						 * Hook: woocommerce_template_single_rating.
						 *
						 * @hooked woocommerce_template_single_rating - 10
						 */
						do_action('output_rating_products_for_product_detail') ?>
					</div>

					<!-- Show price -->
					<?php if (get_post_meta(get_the_ID(), '_sale_price', true) > 0) { ?>
						<h4>
							<?php echo number_format(get_post_meta(get_the_ID(), '_sale_price', true), $args['decimals'], $args['decimal_separator'], $args['thousand_separator']); ?>
							<?= get_woocommerce_currency_symbol($args['currency']) ?>
							<span>
								<?php echo number_format(get_post_meta(get_the_ID(), '_regular_price', true), $args['decimals'], $args['decimal_separator'], $args['thousand_separator']); ?>
								<?= get_woocommerce_currency_symbol($args['currency']) ?>
							</span>
						</h4>
					<?php } else { ?>
						<h4>
							<?php echo number_format(get_post_meta(get_the_ID(), '_regular_price', true), $args['decimals'], $args['decimal_separator'], $args['thousand_separator']); ?>
							<?= get_woocommerce_currency_symbol($args['currency']) ?>
						</h4>
					<?php } ?>

					<!-- Show status stock -->
					<?php if (get_post_meta(get_the_ID(), '_stock_status', true) != "outofstock") { ?>
						<h5><i class="fa fa-check"></i><?php echo get_post_meta(get_the_ID(), '_stock_status', true); ?></h5>
					<?php } else { ?>
						<h5><i class="fa fa-close" style="background-color:red;"></i><?php echo get_post_meta(get_the_ID(), '_stock_status', true); ?></h5>
					<?php }

					do_action('woocommerce_single_product_summary'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Product DEtails Area End -->
<!-- Product Review Tab Area Start -->
<div class="product-review-tab-area bg-gray pt-90 pb-105">
	<div class="container scroll-area">
		<div class="p-d-tab-container">
			<?php do_action('woocommerce_after_single_product_summary'); ?>
		</div>
	</div>
</div>
<!-- Product Review Tab Area End -->
<!-- Protuct Area Start -->
<div class="product-area bg-gray pb-80 mb-95 related-product">
	<?php
	/**
	 * Hook: woocommerce_output_related_products.
	 *
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action('output_related_products_for_product_detail');
	?>

	<?php do_action('woocommerce_after_single_product'); ?>
</div>
<!-- Protuct Area End -->