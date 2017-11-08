<?php

namespace WP_Business_Reviews\Includes\Fields;

use WP_Business_Reviews\Includes\Fields\Field;

class Field_Group {
	private $group_id;
	private $group_name;
	private $fields;

	public function __construct( $group_id, $group_name, array $fields = array() ) {
		$this->group_id   = $group_id;
		$this->group_name = $group_name;

		if ( ! empty( $fields ) ) {
			$this->add_fields( $fields );
		}
	}

	public function add_field( Field $field ) {
		$this->fields[] = $field;
	}

	public function add_fields( array $fields ) {
		foreach ( $fields as $field ) {
			if ( $field instanceof Field ) {
				$this->add_field( $field );
			}
		}
	}

	public function get_group_id() {
		return $this->group_id;
	}

	public function get_group_name() {
		return $this->group_name;
	}

	public function get_fields() {
		return $this->fields;
	}
}
