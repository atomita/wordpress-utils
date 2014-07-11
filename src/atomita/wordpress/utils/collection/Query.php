<?php

namespace atomita\wordpress\utils\collection;

class Query implements \Iterator, \Countable, \ArrayAccess
{
	protected $query;

	function __construct(\WP_Query $query = null)
	{
		if (is_null($query)){
			$query = $GLOBALS['wp_query'];
		}
		$this->query = $query;
	}

	function current()
	{
		if ($this->query->current_post === -1){
			$this->query->the_post();
		}
		else{
			$GLOBALS['post'] = $this->query->post;
			\setup_postdata($this->query->post);
		}
		return $this->query->post;
	}

	function key()
	{
		return $this->query->current_post;
	}

	function next()
	{
		$this->query->next_post();
	}

	function rewind()
	{
		$this->query->rewind_posts();
	}

	function valid()
	{
		return $this->query->have_posts();
	}

	function count()
	{
		return $this->query->post_count;
	}

	function offsetSet($offset, $value){
		throw new \UnderflowException;
	}

	function offsetExists($offset) {
		return isset($this->query->posts[$offset]);
	}

	function offsetUnset($offset){
		throw new \UnderflowException;
	}

	function offsetGet($offset) {
		return isset($this->query->posts[$offset]) ? $this->query->posts[$offset] : null;
	}

}
