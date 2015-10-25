<?php

class Product {
	public $name;
	public $price;

	function __construct ( $name, $price) {
		$this->name = $name;
		$this->price = $price;
	}
}


class ProcessSale  {
	private $callbacks;

	function registerCallback ($callback) {
		if( !is_callable( $callback) ) {
			throw new Exception("Функция обратного вызова не вызываема");
			
		}

		$this->callbacks[] = $callback;
	}

	function sale( $product) {
		print "{ $product->name}: обрабатывается ....\n";
		foreach ($this->callbacks as $callback) {
			call_user_func($callback, $product);
		}
	}
}


$logger = create_function('$product', 'print "Записываем... ({$product->name})\n ";');

$processor = new ProcessSale();

$processor->registerCallback($logger);

$processor->sale( new Product("ываы", 6));
$processor->sale( new Product("ertert", 7));