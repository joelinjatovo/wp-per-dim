<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap form-wrap">
    <div class="about-text"></div>
    <form method="post" id="mainform" action="" enctype="multipart/form-data">
        <?php wp_nonce_field( 'wppd-welcomes' ); ?>
        <?php if( $model && ( $model->getPkValue() > 0 ) ) : ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Modifier un suivi', 'wppd' ); ?></h1>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-trackers&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter un suivi', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="tracker-title">Titre du suivi</label>
            <input name="tracker-title" id="tracker-title" type="text" value="<?php echo $model->title; ?>" size="40" aria-required="true">
            <p>Ce titre est utilisé un peu partout sur votre site.</p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>