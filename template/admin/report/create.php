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
            <h1 class="wp-heading-inline"><?php echo __( 'Modifier une donnée', 'wppd' ); ?></h1>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter une donnée', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="report-indicator">Indicateur</label>
            <select name="report-indicator" id="report-indicator" data-id="<?php echo $model->getPkValue(); ?>" class="postform" style="min-width: 300px;">
                <?php foreach($indicators as $indicator): ?>
                    <option class="level-0" value="<?php echo $indicator->id; ?>" <?php selected($indicator->id, $model->indicator_id, true); ?> ><?php echo $indicator->title; ?></option>
                <?php endforeach; ?>
            </select>
            <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="report-type">Type</label>
                <select name="report-type" id="report-type" class="postform" style="min-width: 300px;">
                    <option class="level-0" value="cf" <?php selected('cf', $model->type, true); ?>>CF</option>
                    <option class="level-0" value="km" <?php selected('km', $model->type, true); ?>>KM</option>
                </select>
                <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="report-results">Periodes et Valeurs</label>
            <div class="results-wrapper" id="report-results">
                <table class="wrapper" width="100%">
                    <tbody class="container" id="report-results-container">
                        <?php foreach($model->getResults() as $key => $result): ?>
                            <tr class="row">
                                <td width="10%"><span class="period"><?php echo $period = $result->getPeriod()? $period->title : __('Non renseigné', 'wppd'); ?></span></td>
                                <td width="80%">
                                    <input type="hidden" name="report-results[<?php echo $key; ?>][id]" value="<?php echo $result->getPkValue(); ?>" />
                                    <input type="hidden" name="report-results[<?php echo $key; ?>][period]" value="<?php echo $result->period_id; ?>" />
                                    <input type="text" name="report-results[<?php echo $key; ?>][value]" value="<?php echo $result->value; ?>" />
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p></p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>