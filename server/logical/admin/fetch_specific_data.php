<?php
ini_set("display_errors",1);
include('../../database/database.php');
include('../../vendor/autoload.php');

use \Firebase\JWT\JWT;

header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header("Access-Control-Allow-Headers:Content-Type");


$database_obj=new Database();

if($_SERVER['REQUEST_METHOD']==="POST")
{
      $data=json_decode(file_get_contents("php://input"));
      $headers=getallheaders();
     
          try
          {
            $jwt=$headers['Authorization'];
            $secret_key="losahji679309";
            $decoded_data=JWT::decode($jwt,$secret_key,array('HS256'));

            $database_obj->admin_id=$decoded_data->data->admin_id;
            $database_obj->product_id=$data->product_id;
            if($database_obj->fetch_specific_data())
            {
              http_response_code(200);
              $data=$database_obj->fetch_specific_data();
              echo json_encode($data); 
              
            }
            else
            {
                http_response_code(500);
                echo json_encode(array(
                    "status"=>0,
                    "message"=>"NO DATA FOUND"
                ));

          }
            
            }catch(Exception $e)
            {
              http_response_code(500);
              echo json_encode(array(
                  "status"=>0,
                  "message"=>$e->getMessage()
              ));
            }
        
      
      
        
      
      

}
?>