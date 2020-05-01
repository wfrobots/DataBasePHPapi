<?php
$method = $_SERVER['REQUEST_METHOD'];
include dirname( __FILE__ ) . '/includes/compatibility.php';
include dirname( __FILE__ ) . '/includes/functions.php';
include dirname( __FILE__ ) . '/includes/class.db-api.php';
include dirname( __FILE__ ) . '/config.php';
$a = '';
$query = $db_api->parse_query();
$_DELETE = array();
$_PUT = array();
/*
if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
    parse_str(file_get_contents('php://input'), $_DELETE);
}
if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
    parse_str(file_get_contents('php://input'), $_PUT);
}
*/
//die();
$db_api->set_db( $query['db'] );

switch ($method) {
  case 'GET':
    {
        $results = $db_api->query( $query );
        $renderer = 'render_' . $query['format'];
        $db_api->$renderer( $results, $query );
    }
    break;
  case 'PUT':{
    $input = file_get_contents('php://input');
    parse_str($input, $input);
    //var_dump(array_merge($_REQUEST, $input));
    //$results = $db_api->insert( $input);
  break;
  }
  case 'POST':{
      
      if ($_POST['json'] != ''){
        
            $results = $db_api->upsertjson( $_REQUEST );
          //$results = $db_api->replacejson( $_REQUEST );
      }
      else{
            $results = $db_api->insertorreplace( $_REQUEST );    
      }
   echo $results;
    break;
  }
  case 'DELETE':{
    $sql = "delete `$table` where id=$key"; 
    $results = $db_api->delete( $_REQUEST);
    break;
  }
    //var_dump($_DELETE);
}
 



