<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table wppd-table table-dashboard-km">
                <tbody class="items">
                    <?php foreach($datas as $data): ?>
                    <tr class="item-row">
                        <td class="item-title"><?php echo $data->id; ?>-<?php echo $data->title; ?></td>
                        <td class="item-value"><?php echo $data->value; ?></td>
                        <td class="item-progress"><?php echo $data->value2; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>