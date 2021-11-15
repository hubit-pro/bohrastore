<?php
 ini_set("display_errors",1);
include('../../vendor/autoload.php');
use \Firebase\JWT\JWT;
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header("Access-Control-Allow-Headers:Content-Type,Authorization");

include('../../database/database.php');
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
            $database_obj->category=$data->category;
                
            if($database_obj->create_category())
                     {
                         http_response_code(200);
                         echo json_encode(array(
                             "status"=>1,
                            "message"=>"category   has been created"
            
                     ));

                       
                     }
                    else
                     {
                     http_response_code(500);
                     echo json_encode(array(
                        "status"=>0,
                        "message"=>"Failed to  register category.try again"
            
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