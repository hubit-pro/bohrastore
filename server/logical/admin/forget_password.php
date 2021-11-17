<?php
ini_set("display_errors",1);
include('../../vendor/autoload.php');
use \Firebase\JWT\JWT;
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header("Access-Control-Allow-Headers: Content-Type,Authorization");


include('../../database/database.php');
$database_obj=new Database();

if($_SERVER['REQUEST_METHOD']==="POST")
{
  
      $data=json_decode(file_get_contents("php://input"));
    //   $headers=getallheaders();
   

      if(isset($data->email_id))
      {
        try
        {
        //   $jwt=$headers['Authorization'];
        //   $secret_key="losahji679309";
        //   $decoded_data=JWT::decode($jwt,$secret_key,array('HS256'));
          
     
        //   $database_obj->product_id=$data->product_id;


         
     
         
        $database_obj->email_id=$data->email_id;
         

          if($database_obj->forget_password())
          {
            
            http_response_code(200);
            echo json_encode(array(
                "status"=>1,
                "message"=>"email has been sent"
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
}
        
?>