<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap nexway-wrap">
    <h1 class="wp-heading-inline"><?php echo __( 'Liste des périodes', 'wppd' ); ?></h1>
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-periods&action=create' ) ); ?>" class="page-title-action"><?php echo __( 'Ajouter', 'wppd' ); ?></a>
    <hr class="wp-header-end">
    <div class="about-text"></div>
    <div class="col-wrap">
        <form id="posts-filter" method="post">
            <div class="tablenav top">
            </div>
            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                        <th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Titre', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:tag">
                    <?php foreach($models as $item): ?>
                        <?php $model = \WpPerDim\Models\App\Period::fromWp($item); ?>
                        <tr id="tag-<?php echo $model->getPkValue(); ?>" class="level-0">
                            <td class="name column-name has-row-actions column-primary" data-colname="<?php echo __( 'Titre', 'wppd' ); ?>"><strong>
                                <a class="row-title" href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-periods&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>"><?php echo $model->title; ?></a></strong><br>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-periods&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Modifier</a> | </span>
                                    <span class="trash"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-periods&action=delete&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" class="submitdelete" aria-label="<?php echo sprintf( __( 'Supprimer «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Supprimer</a> | </span>
                                    <span class="view"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-periods&action=show&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Voir «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Afficher</a></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th scope="col" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Titre', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>