<?php

declare(encoding='UTF-8');
namespace DataModeler\Type;

use \DataModeler\Type;

class FloatType extends Type {
	
	public function __construct() {
		parent::__construct();
		
		$this->default = 0.0;
		$this->value = 0.0;
	}
	
	public function setDefault($default) {
		$this->default = $this->roundTo($default);
		return $this;
	}
	
	public function setValue($value) {
		$this->value = $this->roundTo($value);
		return $this;
	}
	
	private function roundTo($value) {
		$value = floatval($value);
		if ( $this->precision > -1 ) {
			$value = round($value, $this->precision);
		}
		return $value;
	}
	
}