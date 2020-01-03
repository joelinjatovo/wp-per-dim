<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container wppd-container">
    <div class="row">
        <div class="col-md-12 m-2">
            <div>
                <h5><?php _e('Indicators', 'wppd'); ?></h5>
                <div class="indicators">
                    <select class="select-indicator">
                        <?php foreach($indicators as $indicator): ?>
                        <option value="<?php echo $indicator['id']; ?>"><?php echo $indicator['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 m-2">
            <div>
                <h5><?php _e('Periods', 'wppd'); ?></h5>
                <div class="period-buttons">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 m-2">
            <div id="chartdiv" style="width: 100%; height 400px;"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
var indicators_data = <?php echo json_encode($indicators); ?>;
</script>