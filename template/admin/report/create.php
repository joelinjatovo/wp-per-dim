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
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=create' ) ); ?>" class="page-title-action"><?php echo __( 'Ajouter', 'wppd' ); ?></a>
        <?php else: ?>
            <h1 class="wp-heading-inline"><?php echo __( 'Ajouter une donnée', 'wppd' ); ?></h1>
        <?php endif; ?>
        <hr class="wp-header-end">
        
        <div class="form-field form-required term-name-wrap">
            <label for="report-indicator"><?php echo __( 'Indicateur', 'wppd' ); ?></label>
            <?php if( $model && ( $model->getPkValue() > 0 ) ) : ?>
                <input type="hidden" name="report-indicator" value="<?php echo $model->indicator_id; ?>">
            <?php endif; ?>
            <select <?php echo ( $model && ( $model->getPkValue() > 0 ) ) ? 'disabled' : ''; ?> name="report-indicator" id="report-indicator" data-id="<?php echo $model->getPkValue(); ?>" class="postform" style="min-width: 300px;">
                <option class="level-0" value="-1"><?php echo __( 'Sélectionnez un indicateur', 'wppd' ); ?></option>
                <?php foreach($indicators as $indicator): ?>
                    <?php $reports = $indicator->getReports(); ?>
                    <option class="level-0" value="<?php echo $indicator->id; ?>" <?php selected($indicator->id, $model->indicator_id, true); ?> <?php count($reports) > 0 ? 'disabled' : '' ; ?> ><?php echo $indicator->title; ?></option>
                <?php endforeach; ?>
            </select>
            <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="report-type"><?php echo __( 'Type', 'wppd' ); ?></label>
                <select name="report-type" id="report-type" class="postform" style="min-width: 300px;">
                    <option class="level-0" value="cf" <?php selected('cf', $model->type, true); ?>>CF</option>
                    <option class="level-0" value="km" <?php selected('km', $model->type, true); ?>>KM</option>
                </select>
                <p></p>
        </div>
        <div class="form-field term-parent-wrap">
            <label for="report-results"><?php echo __( 'Periodes et Valeurs', 'wppd' ); ?></label>
            <div class="results-wrapper" id="report-results">
                <table class="wrapper" width="100%">
                    <tbody class="container" id="report-results-container">
                        <?php foreach($model->getResults() as $key => $result): ?>
                            <?php $period = $result->getPeriod(); ?>
                            <tr class="row">
                                <td width="10%"><span class="period"><?php echo $period ? $period->title : __('Non renseigné', 'wppd'); ?></span></td>
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
        <div class="form-field form-required term-name-wrap">
            <label for="report-link"><?php echo __( 'Lien connexe', 'wppd' ); ?></label>
            <input name="report-link" id="report-link" type="text" value="<?php echo $model->link; ?>" size="200" aria-required="true">
            <p><?php echo __( 'Ce lien est utilisé pour retrouver les données en question.', 'wppd' ); ?></p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Enregistrer', 'wppd' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>