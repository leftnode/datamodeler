<?php

declare(encoding='UTF-8');
namespace DataModelerTest;

use \DataModeler\Model;

require_once 'lib/Model.php';

class Order extends Model {
	protected $table = 'orders';
	
	protected $pkey = 'order_id';
	
	/** [type INTEGER] */
	private $order_id = 0;
	
	/** [type DATETIME] */
	private $date_created = NULL;
	
	/** [type DATETIME] [default NULL] */
	private $date_updated = NULL;
	
	/** [type DATE] */
	private $date_available = NULL;
	
	/** [type INTEGER] */
	private $customer_id = 0;
	
	/** [type FLOAT] [precision 4]*/
	private $total = 0.0;
	
	/** [type STRING] [maxlength 64] */
	private $name = NULL;
}