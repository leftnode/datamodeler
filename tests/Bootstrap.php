<?php

declare(encoding='UTF-8');
namespace DataModeler;

require_once 'PHPUnit/Framework.php';

$data_modeler_test_path = dirname(__FILE__);
$data_modeler_lib_path  = $data_modeler_test_path . '/../';
set_include_path(get_include_path() . PATH_SEPARATOR . $data_modeler_lib_path . PATH_SEPARATOR . $data_modeler_test_path);