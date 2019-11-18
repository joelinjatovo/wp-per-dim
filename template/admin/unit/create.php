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
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-units&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter une unité', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="unit-title">Titre de l'unité</label>
            <input name="unit-title" id="unit-title" type="text" value="<?php echo $model->title; ?>" size="40" aria-required="true">
            <p>Ce titre est utilisé un peu partout sur votre site.</p>
        </div>
            <div class="form-field term-slug-wrap">
            <label for="unit-label">Libellé</label>
            <input name="unit-label" id="unit-label" type="text" value="<?php echo $model->label; ?>" size="40">
            <p></p>
        </div>
        <div class="form-field term-parent-wrap" style="display:none;">
            <label for="parent">Catégorie parente</label>
                <select name="parent" id="parent" class="postform">
                    <option value="-1">Aucun</option>
                    <option class="level-0" value="1">Non classé</option>
                </select>
                <p>Les catégories, contrairement aux étiquettes, peuvent avoir une hiérarchie. Vous pouvez avoir une catégorie nommée Jazz, et à l’intérieur, plusieurs catégories comme Bebop et Big Band. Ceci est totalement facultatif.</p>
        </div>
        <div class="form-field term-description-wrap" style="display:none;">
            <label for="tag-description">Description</label>
            <textarea name="description" id="tag-description" rows="5" cols="40"></textarea>
            <p>La description n’est pas très utilisée par défaut, cependant de plus en plus de thèmes l’affichent.</p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Enregistrer', 'wppd' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>