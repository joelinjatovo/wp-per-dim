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
                <option class="level-0" value="-1">Sélectionnez un indicateur</option>
                <?php foreach($indicators as $indicator): ?>
                    <?php $reports = $indicator->getReports(); ?>
                    <option class="level-0" value="<?php echo $indicator->id; ?>" <?php selected($indicator->id, $model->indicator_id, true); ?> <?php count($reports) > 0 ? 'disabled' : '' ; ?> ><?php echo $indicator->title; ?></option>
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
                        <?php $key = 0; ?>
                        <?php foreach($model->getResultsPerPeriod() as $period_id => $results): ?>
                            <?php $period = \WpPerDim\Models\App\Period::find($period_id); ?>
                            <tr class="row">
                                <td width="10%"><span class="period"><?php echo $period ? $period->title : __('Non renseigné', 'wppd'); ?></span></td>
                                <td width="80%">
                                    <?php foreach($results as $index => $result): ?>
                                        <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][id]" value="<?php echo $result->getPkValue(); ?>" />
                                        <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][period]" value="<?php echo $result->period_id; ?>" />
                                        <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][tracker]" value="<?php echo $result->tracker_id; ?>" />
                                        <input type="text" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][value]" value="<?php echo $result->value; ?>" />
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <?php $key++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p></p>
        </div>
        <div class="form-field form-required term-name-wrap">
            <label for="report-link">Lien connexe</label>
            <input name="report-link" id="report-link" type="text" value="<?php echo $model->link; ?>" size="200" aria-required="true">
            <p>Ce lien est utilisé pour retrouvé les données en question.</p>
        </div>
		<p class="submit">
			<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
				<button name="save" class="button-primary wppd-save-button" type="submit" value="<?php esc_attr_e( 'Enregistrer', 'wppd' ); ?>"><?php esc_html_e( 'Enregistrer', 'wppd' ); ?></button>
			<?php endif; ?>
		</p>
	</form>
</div>