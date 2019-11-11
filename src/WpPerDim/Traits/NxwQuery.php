<?php
namespace WpPerDim\Traits;

/**
 * TraitQuery
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 */
trait NxwQuery{

	/**
	 * Format specifiers for DB columns. Columns not listed here default to %s. Initialized during WP load.
	 *
	 * Keys are column names, values are format types: 'ID' => '%d'
	 *
	 * @since 2.8.0
	 * @see wpdb::prepare()
	 * @see wpdb::insert()
	 * @see wpdb::update()
	 * @see wpdb::delete()
	 * @see wp_set_wpdb_vars()
	 * @var array
	 */
	public $field_types = array();

	/**
	 * Processes arrays of field/value pairs and field formats.
	 *
	 * This is a helper method for wpdb's CRUD methods, which take field/value
	 * pairs for inserts, updates, and where clauses. This method first pairs
	 * each value with a format. Then it determines the charset of that field,
	 * using that to determine if any invalid text would be stripped. If text is
	 * stripped, then field processing is rejected and the query fails.
	 *
	 * @since 4.2.0
	 *
	 * @param string $table  Table name.
	 * @param array  $data   Field/value pair.
	 * @param mixed  $format Format for each field.
	 * @return array|false Returns an array of fields that contain paired values
	 *                    and formats. Returns false for invalid values.
	 */
	protected function process_fields( $table, $data, $format ) {
		$data = $this->process_field_formats( $data, $format );
		if ( false === $data ) {
			return false;
		}

		return $data;
	}

	/**
	 * Prepares arrays of value/format pairs as passed to wpdb CRUD methods.
	 *
	 * @since 4.2.0
	 *
	 * @param array $data   Array of fields to values.
	 * @param mixed $format Formats to be mapped to the values in $data.
	 * @return array Array, keyed by field names with values being an array
	 *               of 'value' and 'format' keys.
	 */
	protected function process_field_formats( $data, $format ) {
		$formats = $original_formats = (array) $format;

		foreach ( $data as $field => $value ) {
			$value = array(
				'value'  => $value,
				'format' => '%s',
			);

			if ( ! empty( $format ) ) {
				$value['format'] = array_shift( $formats );
				if ( ! $value['format'] ) {
					$value['format'] = reset( $original_formats );
				}
			} elseif ( isset( $this->field_types[ $field ] ) ) {
				$value['format'] = $this->field_types[ $field ];
			}

			$data[ $field ] = $value;
		}

		return $data;
	}
}