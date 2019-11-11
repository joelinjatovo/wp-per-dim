<?php
namespace WpPerDim\WordPress\Admin;

/**
 * XmlImport
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class XmlImport extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'WpPerDim-import';
		$this->label = __( 'Importer XML', 'WpPerDim' );
		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_welcomes() {

		$welcomes = apply_filters(
			'WpPerDim_sync_welcomes',
			array(

				array(
					'title' => __( 'Téléverser le catalogue vers Database', 'WpPerDim' ),
					'type'  => 'title',
					'desc'  => __( 'Allow to upload WpPerDim product catalogue and import immediately to woocommerce product.', 'WpPerDim' ),
					'id'    => 'nxw_sync',
				),

				array(
					'id'              => 'nxw-table',
					'type'            => 'table-start',
				),

				array(
					'title'           => __( 'Upload Catalog File', 'WpPerDim' ),
					'desc'            => __( 'Choose xml catalog file and import it.', 'WpPerDim' ),
					'id'              => 'WpPerDim_file',
					'default'         => 'no',
					'type'            => 'file',
					'show_if_checked' => 'option',
				),

				array(
					'id'              => 'nxw-end',
					'type'            => 'table-end',
				),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_sync',
				),

				array(
					'type'  => 'submit',
					'title' => __( 'Upload and Import', 'WpPerDim' ),
					'id'    => 'nxw_submit',
				),

			)
		);

		return apply_filters( 'WpPerDim_get_welcomes_' . $this->id, $welcomes );
	}

    /**
     * Run POST request.
     * Override
     */
    public function save() {
        if ( isset( $_FILES['WpPerDim_file'] ) ) {
            $dir = NXW_DIR . 'assets/uploads';
            if(!is_dir($dir)){mkdir($dir);}

            $file = $_FILES['WpPerDim_file'];
            $temp_path = $file['tmp_name'];
            $name = 'uploaded_catalog_' . date( 'Ymdhis' ) . '_' . $file['name'];
            $path = $dir.'/'.$name;
            $uploaded = move_uploaded_file( $temp_path, $path );
            if( $uploaded && is_file( $path ) ){
                try{
                    $t1     = time();
                    $result = \WpPerDim\Models\Importer\CatalogXmlImporter::import($path);
                    $t2     = time();
                    nxw_log('XMLImport', 'CatalogXmlImporter :' . ( $t2 - $t1 ) );
                    
                    Welcome::add_message( 
                         sprintf( __('UPDATE = %s'), $result['update'] ) . ' / ' . 
                         sprintf( __('NEW = %s'), $result['insert'] ) 
                    );
                }catch(\Exception $e){
                    Welcome::add_error( $e->getMessage() );
                }
            }else{
                $upload_errors = [
                    UPLOAD_ERR_OK         => __('There is no error, the file uploaded with success.', 'WpPerDim'),
                    UPLOAD_ERR_INI_SIZE   => __('The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'WpPerDim'),
                    UPLOAD_ERR_FORM_SIZE  => __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.', 'WpPerDim'),
                    UPLOAD_ERR_PARTIAL    => __('The uploaded file was only partially uploaded.', 'WpPerDim'),
                    UPLOAD_ERR_NO_FILE    => __('No file was uploaded.', 'WpPerDim'),
                    UPLOAD_ERR_NO_TMP_DIR => __('Missing a temporary folder.', 'WpPerDim'),
                    UPLOAD_ERR_CANT_WRITE => __('Cannot write to target directory. Please fix CHMOD.', 'WpPerDim'),
                    UPLOAD_ERR_EXTENSION  => __('A PHP extension stopped the file upload.', 'WpPerDim'),
                ];
                $error = $file['error'];

                $msg = '';
                if(isset($upload_errors[$error])){
                    $msg = $upload_errors[$error];
                }

                Welcome::add_error( $msg );
            }

        }
    }
}