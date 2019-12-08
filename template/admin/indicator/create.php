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
            <h1 class="wp-heading-inline"><?php echo __( 'Modifier un indicateur', 'wppd' ); ?></h1>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter un indicateur', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="indicator-title"><?php echo __( 'Titre de l\'indicateur', 'wppd' ); ?></label>
            <input name="indicator-title" id="unit-title" type="text" value="<?php echo $model->title; ?>" size="40" aria-required="true">
            <p><?php echo __( 'Ce titre est utilisé un peu partout sur votre site.', 'wppd' ); ?></p>
        </div>
        <div class="form-field term-description-wrap">
            <label for="indicator-description"><?php echo __( 'Description de l\'indicateur.', 'wppd' ); ?></label>
            <textarea name="indicator-description" id="indicator-description" rows="5" cols="40"><?php echo $model->description; ?></textarea>
            <p><?php echo __( 'La description n’est pas très utilisée par défaut, cependant de plus en plus de thèmes l’affichent.', 'wppd' ); ?></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="indicator-unit"><?php echo __( 'Unité de mesure de l\'indicateur', 'wppd' ); ?></label>
            <select name="indicator-unit" id="indicator-init" class="postform" style="min-width: 300px;">
                <option value="-1"><?php echo __( 'Aucune unité', 'wppd' ); ?></option>
                <?php foreach($units as $unit): ?>
                    <option class="level-0" value="<?php echo $unit->id; ?>" <?php selected($unit->id, $model->unit_id, true); ?> ><?php echo $unit->title; ?> ( <?php echo $unit->label; ?> )</option>
                <?php endforeach; ?>
            </select>
            <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="indicator-organism"><?php echo __( 'Organisme', 'wppd' ); ?></label>
            <select name="indicator-organism" id="indicator-organism" class="postform" style="min-width: 300px;">
                <option value="-1"><?php echo __( 'Aucun organisme', 'wppd' ); ?></option>
                <?php foreach($organisms as $organism): ?>
                    <option class="level-0" value="<?php echo $organism->id; ?>" <?php selected($organism->id, $model->organism_id, true); ?> ><?php echo $organism->title; ?></option>
                <?php endforeach; ?>
            </select>
            <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="indicator-unit"><?php echo __( 'Periode de suivi de l\'indicateur', 'wppd' ); ?></label>
            <div class="repeatable-wrapper">
                <div class="repeatable">
                    <table class="wrapper" width="100%">
                        <tbody class="container">
                            <tr class="template row">
                                <td width="80%">
                                    <input type="hidden" name="indicator-periods[{{row-count-placeholder}}][id]" />
                                    <input type="text" name="indicator-periods[{{row-count-placeholder}}][title]" />
                                </td>
                                <td width="10%"><button type="button" class="remove" style="color: red;"><?php echo __( 'Supprimer', 'wppd' ); ?></button></td>
                            </tr>
                            <?php $periods = $model->getPeriods(); ?>
                            <?php if( count($periods) > 0 ): ?>
                                <?php foreach($periods as $key => $period): ?>
                                    <tr class="row">
                                        <td width="80%">
                                            <input type="hidden" name="indicator-periods[<?php echo $key; ?>][id]" value="<?php echo $period->getPkValue(); ?>" />
                                            <input type="text" name="indicator-periods[<?php echo $key; ?>][title]" value="<?php echo $period->title; ?>" />
                                        </td>
                                        <td width="10%"><button type="button" class="remove" style="color: red;"><?php echo __( 'Supprimer', 'wppd' ); ?></button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="row">
                                    <td width="80%">
                                        <input type="hidden" name="indicator-periods[0][id]" value="" />
                                        <input type="text" name="indicator-periods[0][title]" value="" />
                                    </td>
                                    <td width="10%"><button type="button" class="remove" style="color: red;"><?php echo __( 'Supprimer', 'wppd' ); ?></button></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td width="10%" colspan="3"><button type="button" class="add"><?php echo __( 'Ajouter', 'wppd' ); ?></button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="indicator-graph"><?php echo __( 'Type de graphe de l\'indicateur', 'wppd' ); ?></label>
            <select name="indicator-graph" id="indicator-graph" class="postform" style="min-width: 300px;">
                <option value="-1"><?php echo __( 'Sélectionnez un type de graphe', 'wppd' ); ?></option>
                <option class="level-0" value="pie" <?php selected('pie', $model->graph, true); ?>><?php echo __( 'Pie', 'wppd' ); ?></option>
                <option class="level-0" value="donut" <?php selected('donut', $model->graph, true); ?>><?php echo __( 'Donut', 'wppd' ); ?></option>
                <option class="level-0" value="bar" <?php selected('bar', $model->graph, true); ?>><?php echo __( 'Bar Chart', 'wppd' ); ?></option>
                <option class="level-0" value="line" <?php selected('line', $model->graph, true); ?>><?php echo __( 'Line Chart', 'wppd' ); ?></option>
            </select>
            <p></p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Enregistrer', 'wppd' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>