<?php
/**
 * Admin View: Dashboard
 *
 * @package WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap form-wrap">
    <div class="about-text"></div>
    <form method="post" id="mainform" action="" enctype="multipart/form-data">
        <?php wp_nonce_field( 'wppd-welcomes' ); ?>
        <?php if( $model && ( $model->getPkValue() > 0 ) ) : ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Modifier un indicateur', 'wppd' ); ?></h1>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter un indicateur', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="indicator-title">Titre de l'indicateur</label>
            <input name="indicator-title" id="unit-title" type="text" value="<?php echo $model->title; ?>" size="40" aria-required="true">
            <p>Ce titre est utilisé un peu partout sur votre site.</p>
        </div>
        <div class="form-field term-description-wrap">
            <label for="indicator-description">Description de l'indicateur</label>
            <textarea name="indicator-description" id="indicator-description" rows="5" cols="40"></textarea>
            <p>La description n’est pas très utilisée par défaut, cependant de plus en plus de thèmes l’affichent.</p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="indicator-unit">Unité de mesure de l'indicateur</label>
                <select name="indicator-unit" id="indicator-init" class="postform" style="min-width: 300px;">
                    <option value="-1">Aucun</option>
                    <option class="level-0" value="1">Non classé</option>
                </select>
                <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="indicator-graph">Type de graphe de l'indicateur</label>
                <select name="indicator-graph" id="indicator-graph" class="postform" style="min-width: 300px;">
                    <option value="-1">Aucun</option>
                    <option class="level-0" value="1">Non classé</option>
                </select>
                <p></p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>