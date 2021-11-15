<?php
ini_set("display_errors",1);
include('../vendor/autoload.php');
use \Firebase\JWT\JWT;
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header("Access-Control-Allow-Headers:Content-Type,Authorization");

include('../database/database.php');
$database_obj=new Database();

if($_SERVER['REQUEST_METHOD']==="GET")
{

    //    $data=json_decode(file_get_contents("php://input"));
    //  $database_obj->admin_id=$data->admin_id;

     $headers=getallheaders();
     try
     {
        // $jwt= $headers['Authorization'];
        // $secret_key="nrk45589";
        // $decoded_data=JWT::decode($jwt,$secret_key,array('HS256'));


        // $database_obj->owner_id=$data->owner_id;

        // $database_obj->admin_id=$decoded_data->data->admin_id;
        // $database_obj->vehicle_id=$data->vehicle_id;


        $product_data= $database_obj->fetch_all_product_data();
      
       
        if($product_data)
            {
                http_response_code(200);
                echo json_encode(array(
                "product_data"=>$product_data
            ));
                        

            }
        else
      {
          http_response_code(404);
          echo json_encode(array(
              "status"=>0,
              "message"=>"no data found"
          ));
      }

     }catch(Exception $e)
     {
         echo json_encode(array(
             "status"=>0,
             "message"=>$e->getMessage()
         ));

     }

     

}




?>