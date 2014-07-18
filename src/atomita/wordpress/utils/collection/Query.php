<?php

namespace atomita\wordpress\utils\collection;

class Query implements \Iterator, \Countable, \ArrayAccess
{
	protected $query;

	protected function thePost(){
		if ($this->query->have_posts()){
			$this->query->the_post();
		}
	}

	function __construct(\WP_Query $query = null)
	{
		if (is_null($query)){
			$query = $GLOBALS['wp_query'];
		}
		$this->query = $query;
	}

	function current()
	{
		$GLOBALS['post'] = $this->query->post;
		\setup_postdata($this->query->post);
		return $this->query->post;
	}

	function key()
	{
		return $this->query->current_post;
	}

	function next()
	{
		$this->thePost();
	}

	function rewind()
	{
		$this->query->rewind_posts();
		$this->thePost();
	}

	function valid()
	{
		return isset($this->query->posts[$this->key()]);
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
