<?php

declare(encoding='UTF-8');
namespace DataModelerTest;

use \DataModeler\Model,
	\DataModelerTest\Product;

require_once 'Product.php';
require_once 'Order.php';

class ModelTest extends TestCase {

	public function test__Call_CanSetAndGetValue() {
		$name = 'DataModeler';
		
		$product = new Product;
		$product->setName($name);
		
		$this->assertEquals($name, $product->getName());
	}

	public function test__Get_ReturnsValue() {
		$customerId = 10;
		
		$product = new Product;
		$product->customer_id = $customerId;
		
		$this->assertEquals($customerId, $product->customer_id);
	}
	
	public function test__Get_ReturnsId() {
		$productId = 10;
		
		$product = new Product;
		$product->product_id = $productId;
		
		$this->assertEquals($productId, $product->product_id);
		$this->assertEquals($productId, $product->id());
	}
	
	public function test__Get_NullIfMissing() {
		$product = new Product;
		
		$this->assertTrue(is_null($product->unknown_field));
	}
	
	public function testEqualTo_AreEqual() {
		$product1 = new Product;
		$product2 = new Product;
		
		$this->assertTrue($product1->equalTo($product2));
		$this->assertTrue($product2->equalTo($product1));
	}
	
	public function testEqualTo_AreEqualWithChanges() {
		$product1 = new Product;
		$product2 = new Product;
		
		$product1->setName('Product Name')
			->setPrice(10.45);

		$product2->setName('Product Name')
			->setPrice(10.45);
		
		$this->assertTrue($product1->equalTo($product2));
		$this->assertTrue($product2->equalTo($product1));
	}
	
	public function testEqualTo_AreNotEqual() {
		$product1 = new Product;
		$product2 = new Product;
		
		$product1->setPrice(11.45);
		$product2->setPrice(8.99);
		
		$this->assertFalse($product1->equalTo($product2));
		$this->assertFalse($product2->equalTo($product1));
	}
	
	public function testExists_ModelDoesNotExists() {
		$product = new Product;
		
		$this->assertFalse($product->exists());
	}
	
	public function testExists_ModelExists() {
		$product = new Product;
		$product->setProductId(10);
		
		$this->assertTrue($product->exists());
	}
	
	public function testField_AddsField() {
		$field = 'discount_price';
		$product = new Product;
		
		$this->assertFalse(array_key_exists($field, $product->model()));
		
		$product->field($field, $this->buildMockType());
		
		$this->assertTrue(array_key_exists($field, $product->model()));
	}
	
	public function testId_ConstrainsToType() {
		$product = new Product;
		$product->id('string');
		
		$this->assertEquals(0, $product->id());
	}
	
	public function testIsA_SameModels() {
		$product1 = new Product;
		$product2 = new Product;
		$order = new Order;
		
		$this->assertTrue($product1->isA($product2));
		$this->assertTrue($product2->isA($product1));
		$this->assertFalse($order->isA($product1));
		$this->assertFalse($order->isA($product2));
	}
	
	public function testLoad_InsertsValues() {
		$productId = 89;
		$customerId = 10;
		$price = 10.85;
		$product = new Product;
		
		$this->assertFalse($product->exists());
		$this->assertTrue(is_null($product->id()));
		
		$product->load(array('customer_id' => $customerId, 'price' => $price));
		$this->assertEquals($customerId, $product->getCustomerId());
		$this->assertEquals($price, $product->getPrice());
		$this->assertFalse($product->exists());
		
		$product->load(array('product_id' => $productId));
		$this->assertEquals($productId, $product->id());
		$this->assertTrue($product->exists());
	}
	
	public function testNvp_ReturnsNameValuePairHash() {
		$product = new Product;
		$pkey = $product->pkey();
		$nvp = $product->nvp();
		
		$reflection = new \ReflectionClass($product);
		$properties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);
		$properties = array_filter($properties, function($v) use ($pkey) { return $v->name != $pkey; });
		
		$this->assertEquals(count($nvp), count($properties));
	}
	
	public function testPkey_CannotContainBackticks() {
		$pkeyWithBackticks = '`p.product_id`';
		$pkeyWithoutBackticks = 'p.product_id';
		
		$product = new Product;
		$product->pkey($pkeyWithBackticks);
		
		$this->assertEquals($pkeyWithoutBackticks, $product->pkey());
	}
	
	public function testSimilarTo_SimilarWhenModelsAndKeysAreSame() {
		$product1 = new Product;
		$product1->id(1);
		$product1->setName('Product 1 Name')
			->setPrice(27.99);
		
		$product2 = new Product;
		$product2->id(2);
		$product2->setPrice(8.56)
			->setName('Product 2 Name');
		
		$this->assertTrue($product1->similarTo($product2));
		$this->assertTrue($product2->similarTo($product1));
	}
	
	public function testSimilarTo_NotSimilarWhenModelsSameAndKeysDifferent() {
		$product1 = new Product;
		$product1->id(1);
		$product1->setName('Product 1 Name')
			->setPrice(27.99);
		
		$product2 = new Product;
		$product2->id(2);
		$product2->field('discount_price', $this->buildMockType());
		$product2->setPrice(8.56)
			->setDiscountPrice(19.99);
		
		$this->assertFalse($product1->similarTo($product2));
		$this->assertFalse($product2->similarTo($product1));
	}
	
	public function testTable_CanBeSet() {
		$table = 'products';
	
		$product = new Product;
		$product->table($table);
		
		$this->assertEquals($table, $product->table()); 
	}
	
	/**
	 * @dataProvider providerValidTableName
	 */
	public function testTable_CanOnlyContainValidCharacters($table) {
		$product = new Product;
		$product->table($table);
		
		$this->assertEquals($table, $product->table());
	}
	
	public function testTable_CannotContainBackticks() {
		$tableWithBackticks = '`table_name`';
		$tableWithoutBackticks = 'table_name';
		
		$product = new Product;
		$product->table($tableWithBackticks);
		
		$this->assertEquals($tableWithoutBackticks, $product->table());
	}
	
	public function providerValidTableName() {
		return array(
			array('products'),
			array('p.products'),
			array('product_list'),
			array('product-list'),
			array('p.product_list'),
			array('p.product-list')
		);
	}
	
	public function providerInvalidFieldName() {
		return array(
			array('vic[]cherubini'),
			array('vic cherubini'),
			array('vic*cherubini'),
			array('vic@cherubini'),
			array('vic()cherubini'),
			array('vic&cherubini')
		);
	}
}