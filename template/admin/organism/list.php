<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap nexway-wrap">
    <h1 class="wp-heading-inline"><?php echo __( 'Liste des organismes', 'wppd' ); ?></h1>
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-organisms&action=create' ) ); ?>" class="page-title-action"><?php echo __( 'Ajouter', 'wppd' ); ?></a>
    <hr class="wp-header-end">
    <div class="about-text"></div>
    <div class="col-wrap">
        <form id="posts-filter" method="post">
            <div class="tablenav top">
            </div>
            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                        <th scope="col" id="id" class="manage-column column-id column-primary sortable desc" style="width: 100px;"><a href=""><span><?php echo __( 'Id', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Nom', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:tag">
                    <?php foreach($models as $item): ?>
                        <?php $model = \WpPerDim\Models\App\Unit::fromWp($item); ?>
                        <tr id="tag-<?php echo $model->getPkValue(); ?>" class="level-0">
                            <td class="slug column-id" data-colname="<?php echo __( 'Id', 'wppd' ); ?>" style="width: 100px;">#<code><?php echo $model->id; ?></code></td>
                            <td class="name column-name has-row-actions column-primary" data-colname="<?php echo __( 'Nom', 'wppd' ); ?>"><strong>
                                <a class="row-title" href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-organisms&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>"><?php echo $model->title; ?></a></strong><br>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-organisms&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Modifier</a> | </span>
                                    <span class="data"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier les données «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Modifier les données</a> | </span>
                                    <span class="trash"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-organisms&action=delete&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" class="submitdelete" aria-label="<?php echo sprintf( __( 'Supprimer «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Supprimer</a></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th scope="col" class="manage-column column-id column-primary sortable desc" style="width: 100px;"><a href=""><span><?php echo __( 'Id', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Nom', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>