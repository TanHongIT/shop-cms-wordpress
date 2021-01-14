<?php

/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if (!defined('ABSPATH')) {
	exit;
} ?>

<?php
if (!empty($breadcrumb)) {

	echo $wrap_before; ?>
	<div class="breadcrumb-area bg-12 text-center" style="padding-top:200px;">
		<div class="container">
			<h1><?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
					<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>
			</h1>
			<nav aria-label="breadcrumb">
				<ul class="breadcrumb">
					<?php
					foreach ($breadcrumb as $key => $crumb) {

						echo $before;

						if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
							echo '<li class="breadcrumb-item"><a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a></li>';
						} else {
							echo esc_html($crumb[0]);
						}

						echo $after;

						if (sizeof($breadcrumb) !== $key + 1) {
							echo $delimiter;
						}
					}

					echo $wrap_after;
					?>
				</ul>
			</nav>
		</div>
	</div>
<?php } ?>