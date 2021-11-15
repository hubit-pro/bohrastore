<?php
 ini_set("display_errors",1);
include('../../vendor/autoload.php');
use \Firebase\JWT\JWT;
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header("Access-Control-Allow-Headers:Content-Type,Authorization");

include('../../database/database.php');
$database_obj=new Database();

 if($_SERVER['REQUEST_METHOD']==="POST")
        {
    
      $headers=getallheaders();
        try
           {
            $jwt=$headers['Authorization'];
            $secret_key="losahji679309";
            $decoded_data=JWT::decode($jwt,$secret_key,array('HS256'));

            
            $database_obj->product_id=$_POST['product_id'];

             $database_obj->product_name=$_POST['product_name'];
             $database_obj->product_size=$_POST['product_size'];
             $database_obj->product_price=$_POST['product_price'];
            //  $database_obj->product_image=$_POST['image'];
             $database_obj->product_desc=$_POST['product_desc'];

            
                    if($database_obj->update_product_info())
                     {
                         http_response_code(200);
                         echo json_encode(array(
                             "status"=>1,
                            "message"=>"data has been updated"
            
                     ));

                       
                     }
                    else
                     {
                     http_response_code(500);
                     echo json_encode(array(
                        "status"=>0,
                        "message"=>"Failed to update.try again"
            
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