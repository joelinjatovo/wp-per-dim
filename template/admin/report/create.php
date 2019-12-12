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
            <h1 class="wp-heading-inline"><?php echo sprintf(__( 'Modifier les données: %s', 'wppd' ), $model->title); ?></h1>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas' ) ); ?>" class="page-title-action"><?php echo __( 'Ajouter', 'wppd' ); ?></a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter ou Modifier les données', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="report-organism"><?php echo __( 'Organisme', 'wppd' ); ?></label>
            <?php if( $model && ( $model->getPkValue() > 0 ) ) : ?>
                <input type="hidden" name="report-organism" value="<?php echo $model->organism_id; ?>">
            <?php endif; ?>
            <select <?php echo ( $model && ( $model->getPkValue() > 0 ) ) ? 'disabled' : ''; ?> name="report-organism" id="report-organism" data-id="<?php echo $model->getPkValue(); ?>" class="postform" style="min-width: 300px;">
                <option class="level-0"><?php echo __( 'Sélectionnez un organisme', 'wppd' ); ?></option>
                <?php foreach($organisms as $organism): ?>
                    <option class="level-0" value="<?php echo $organism->id; ?>" <?php selected($organism->id, $model->id, true); ?> ><?php echo $organism->title; ?></option>
                <?php endforeach; ?>
            </select>
            <p></p>
        </div>
        <div class="form-field term-parent-wrap" id="report-results-container">
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Enregistrer', 'wppd' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>