<?php
namespace WpPerDim;

/**
 * Database
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 */
class Database{
    
    public function saveOptions(){
        //update_option('enable_wp_nonce_validation', 1);
    }
    
    public function unsaveOptions(){
        //delete_option('enable_wp_nonce_validation');
    }
    
    public function install()
    {
        ob_start();
        global $wpdb;
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table_name = $wpdb->prefix . "wppd_organisms";	   		
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
            `id`          BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `title`       VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `label`       VARCHAR(255) COLLATE utf8mb4_unicode_520_ci
        );";
        $wpdb->query($sql);
        echo "Error $table_name: $wpdb->last_error \n";

        $table_name = $wpdb->prefix . "wppd_units";	   		
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
            `id`          BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `title`       VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `label`       VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `organism_id` BIGINT(20),
            INDEX (`organism_id`)
        );";
        $wpdb->query($sql);
        echo "Error $table_name: $wpdb->last_error \n";

        $table_name = $wpdb->prefix . "wppd_indicators";	   		
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
            `id`          BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `title`       VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `description` LONGTEXT     COLLATE utf8mb4_unicode_520_ci,
            `type`        VARCHAR(100) COLLATE utf8mb4_unicode_520_ci,
            `graph`       VARCHAR(100) COLLATE utf8mb4_unicode_520_ci,
            `unit_id`     BIGINT(20),
            `organism_id` BIGINT(20),
            INDEX (`unit_id`),
            INDEX (`type`),
            INDEX (`organism_id`)
        );";
        $wpdb->query($sql);
        echo "Error $table_name: $wpdb->last_error \n";

        $table_name = $wpdb->prefix . "wppd_periods";	   		
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
            `id`           BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `title`        VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `group`        VARCHAR(100) COLLATE utf8mb4_unicode_520_ci,
            `order`        INT(20),
            `indicator_id` BIGINT(20),
            INDEX (`indicator_id`),
            INDEX (`group`)
        );";
        $wpdb->query($sql);
        echo "Error $table_name: $wpdb->last_error \n";

        $table_name = $wpdb->prefix . "wppd_reports";	   		
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
            `id`           BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `title`        VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `link`         VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `indicator_id` BIGINT(20),
            UNIQUE KEY (`indicator_id`)
        );";
        $wpdb->query($sql);
        echo "Error $table_name: $wpdb->last_error \n";

        $table_name = $wpdb->prefix . "wppd_results";	   		
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
            `id`        BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `title`     VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `value`     VARCHAR(255) COLLATE utf8mb4_unicode_520_ci,
            `report_id` BIGINT(20),
            `period_id` BIGINT(20),
            INDEX (`report_id`),
            INDEX (`period_id`)
        );";
        $wpdb->query($sql);
        echo "Error $table_name: $wpdb->last_error \n";
        
        echo date('Y-m-d H:i:s');
        
        $log = ob_get_contents();
        ob_end_clean();
        
        $file = WPPD_DIR . "log/activation.log";
        if(file_exists($file)){
            $current = file_get_contents($file);	
        }else{
            $current = '';
        }
        $current .= "\n====START: ".date("d/m/Y H:i:s")." IP=". $_SERVER['REMOTE_ADDR'] . " ====\n";
        $current .= $log;
        $current .= "\n====END: \n";
        file_put_contents($file,$current);
        
    }   
    
    public function uninstall() {
        return;
        global $wpdb;
        $table_names = [
            $wpdb->prefix . 'wppd_organisms',
            $wpdb->prefix . 'wppd_units',
            $wpdb->prefix . 'wppd_indicators',
            $wpdb->prefix . 'wppd_reports',
            $wpdb->prefix . 'wppd_results',
            $wpdb->prefix . 'wppd_periods',
        ];
        foreach($table_names as $table_name){
            $sql = "DROP TABLE IF EXISTS $table_name";
            $wpdb->query($sql);
        }
    }   
}