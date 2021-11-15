<?php
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
      $headers=getallheaders();
        

      if(isset($data->product_id))
      {
        try
        {
          $jwt=$headers['Authorization'];
          $secret_key="losahji679309";
          $decoded_data=JWT::decode($jwt,$secret_key,array('HS256'));
          
     
          $database_obj->product_id=$data->product_id;


          $datas=$database_obj->fetch_specific_data();
        echo  $remove_image= $datas['product_image'];
                
     
         

         

          if($database_obj->delete_product())
          {
            unlink($remove_image);
            http_response_code(200);
            echo json_encode(array(
                "status"=>1,
                "message"=>"vehicle has been deleted"
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

      else
      {
            http_response_code(404);
            echo json_encode(array(
                "status"=>0,
                "message"=>"data needed"
            ));

      }

      

}


?>