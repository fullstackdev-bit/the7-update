<?php
/**
 * Header template part with main container opener.
 *
 * @package The7
 * @since   1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php //do_action( 'presscore_before_main_container' ) ?>

<div class="page-title title-center solid-bg breadcrumbs-mobile-off page-title-responsive-enabled">
			<div class="wf-wrap">
			<div class="page-title-head hgroup">
			    <h1>Detail</h1></div>
			    	</div>
		</div>

<?php if ( presscore_is_content_visible() ): ?>

<div id="main" <?php presscore_main_container_classes() ?> <?php presscore_main_container_style() ?> >
    
	<?php do_action( 'presscore_main_container_begin' ) ?>

    <div class="main-gradient"></div>
    <div class="wf-wrap">
    <div class="wf-container-main">

	<?php do_action( 'presscore_before_content' ) ?>

<?php endif ?>