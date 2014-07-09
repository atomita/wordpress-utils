<?php

if (!function_exists('query_map')){

	function query_map($callback, WP_Query $query = null){
		if (!is_callable($callback)){
			throw new BadFunctionCallException;
		}
		if (is_null($query)){
			$query = $GLOBALS['wp_query'];
		}

		$result = array();
		while ($query->have_posts()){
			$query->the_post();
			$result[] = $callback($query->get_post());
		}
		return $result;
	}

}
