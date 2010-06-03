<?php

declare(encoding='UTF-8');
namespace DataModelerTest;

require_once 'lib/Model.php';

class ModelTest extends TestCase {

	public function testMagicGetter() {
		$first_name = "Vic Cherubini";
		
		$model = $this->buildMockModel();
		$model->first_name = $first_name;
		
		$this->assertEquals($first_name, $model->first_name);
	}

	
	public function testMagicGetterCanGetPkey() {
		$product_id = 10;
		
		$model = $this->buildMockModel();
		$model->pkey('product_id');
		$model->id($product_id);
		
		
		$this->assertEquals($product_id, $model->product_id);
	}


	public function testMagicSetter() {
		$expected_model_array = array('first_name' => "Vic Cherubini");
		
		$model = $this->buildMockModel();
		$model->first_name = "Vic Cherubini";
		
		$this->assertEquals($expected_model_array, $model->model());
	}
	
	
	public function testMagicSetterCannotSetPkeyInModel() {
		$model = $this->buildMockModel();
		$model->pkey('product_id');
		
		$model->product_id = 10;
		$this->assertEmptyArray($model->model());
	}
	
	
	public function testMagicSetterCanSetPkeyInObject() {
		$pkey = "product_id";
		$product_id = 10;
		
		$model = $this->buildMockModel();
		$model->pkey($pkey);
		$model->$pkey = 10;
		
		$this->assertEquals($product_id, $model->id());
	}
	

	public function testDatetypeIsTimestampByDefault() {
		$model = $this->buildMockModel();
		$model->datetype(100);
		
		$this->assertEquals(\DataModeler\Model::DATETYPE_TIMESTAMP, $model->datetype());
	}
	
	
	public function testDatetypeCanBeNow() {
		$model = $this->buildMockModel();
		$model->datetype(\DataModeler\Model::DATETYPE_NOW);
		
		$this->assertEquals(\DataModeler\Model::DATETYPE_NOW, $model->datetype());
	}
	
	
	public function testDatetypeCanBeTimestamp() {
		$model = $this->buildMockModel();
		$model->datetype(\DataModeler\Model::DATETYPE_TIMESTAMP);
		
		$this->assertEquals(\DataModeler\Model::DATETYPE_TIMESTAMP, $model->datetype());
	}
	
	
	public function testIdIsInitiallyEmpty() {
		$model = $this->buildMockModel();
		$this->assertNull($model->id());
	}
	
	
	public function testIdCanBeSet() {
		$id = 10;
		
		$model = $this->buildMockModel();
		$model->id($id);
		
		$this->assertEquals($id, $model->id());
	}
	
	
	public function testModelIsInitiallyEmpty() {
		$model = $this->buildMockModel();
		
		$this->assertEmptyArray($model->model());
	}
	
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testModelMustBeArray() {
		$model = $this->buildMockModel();
		$model->model(10);
	}
	
	
	public function testModelFirstElementCanBeFalse() {
		$model = $this->buildMockModel();
		$model->model(array(false));
		
		$this->assertNotEmptyArray($model->model());
	}
	
	
	public function testPkeyCannotContainBackticks() {
		$pkey_with_backticks = '`p.product_id`';
		$pkey_without_backticks = 'p.product_id';
		
		$model = $this->buildMockModel();
		$model->pkey($pkey_with_backticks);
		
		$this->assertEquals($pkey_without_backticks, $model->pkey());
	}
	
	
	public function testTableCanBeSet() {
		$table = 'products';
	
		$model = $this->buildMockModel();
		$model->table($table);
		
		$this->assertEquals($table, $model->table()); 
	}
	
	
	/**
	 * @dataProvider providerValidTableNameList
	 */
	public function testTableCanOnlyContainValidCharacters($table) {
		$model = $this->buildMockModel();
		$model->table($table);
		
		$this->assertEquals($table, $model->table());
	}
	
	
	public function testTableCannotContainBackticks() {
		$table_with_backticks = '`table_name`';
		$table_without_backticks = 'table_name';
		
		$model = $this->buildMockModel();
		$model->table($table_with_backticks);
		
		$this->assertEquals($table_without_backticks, $model->table());
	}
	
	
	public function providerValidTableNameList() {
		return array(
			array('products'),
			array('p.products'),
			array('product_list'),
			array('product-list'),
			array('p.product_list'),
			array('p.product-list')
		);
		
	}
}