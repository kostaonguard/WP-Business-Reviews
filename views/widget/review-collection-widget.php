<?php
	echo $this->args['before_widget'];

	if ( ! empty( $this->instance['title'] ) ) {
		echo $this->args['before_title']
		. esc_html( $this->instance['title'] )
		. $this->args['after_title'];
	}

	if ( ! empty( $this->collection ) ) {
		$this->collection->render();
	}

	echo $this->args['after_widget'];
