<?php

declare(encoding='UTF-8');
namespace DataModeler\Type;

use \DataModeler\Type;

class TextType extends Type {
	
	public function __construct() {
		parent::__construct();
		
		$this->default = '';
		$this->value = '';
	}
	
	public function setDefault($default) {
		$this->default = strval($default);
		return $this;
	}
	
	public function setValue($value) {
		$this->value = strval($value);
		return $this;
	}
	
}