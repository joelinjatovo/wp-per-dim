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
            <h1 class="wp-heading-inline"><?php echo __( 'Modifier une unité', 'wppd' ); ?></h1>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-units&action=create' ) ); ?>" class="page-title-action"><?php echo __( 'Ajouter', 'wppd' ); ?></a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter une unité', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="unit-title"><?php echo __( 'Titre de l\'unité', 'wppd' ); ?></label>
            <input name="unit-title" id="unit-title" type="text" value="<?php echo $model->title; ?>" size="40" aria-required="true">
            <p><?php echo __( 'Ce titre est utilisé un peu partout sur votre site.', 'wppd' ); ?></p>
        </div>
            <div class="form-field term-slug-wrap">
            <label for="unit-label"><?php echo __( 'Libellé', 'wppd' ); ?></label>
            <input name="unit-label" id="unit-label" type="text" value="<?php echo $model->label; ?>" size="40">
            <p></p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Enregistrer', 'wppd' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>