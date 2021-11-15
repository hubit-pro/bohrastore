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
    if(isset($data->username)&&($data->passwordd))
    {
        $database_obj->user=$data->username;
        $database_obj->pass=$data->passwordd;
    
    
        $admin= $database_obj->check_login();
        if(!empty($admin))
        {
            
           
            $iss="loalhost";
            $iat=time();
            $exp=$iat+6400;
            $admin_data=array(
                "admin_id"=>$admin['id'],
                "username"=>$admin['username'],
               
               
            );
    
    
            $payload_info=array(
                "iss"=>$iss,
                "iat"=>$iat,
                "exp"=>$exp,
                "data"=>$admin_data
            );
            $secret_key="losahji679309";
    
            $jwt=JWT::encode($payload_info,$secret_key);
    
    
            echo json_encode(array(
    
                'messages'=>'logged in successfully.',
                "jwt"=>$jwt,
                'status'=>true
            ));
        }
    
        else
    
        {
            http_response_code(401);
    
             echo json_encode(array(
            'status'=>0,
    
            'messages'=>'credentials do not match'
           
           
        ));
        }

    }
    else
    {
        http_response_code(404);
        echo json_encode(array(
            "status"=>0,
            "message"=>"all data needed"

        ));

    }
 



}
else
{
    http_response_code(500);
    echo json_encode(array(
        "status"=>0,
        "message"=>"request error"

    ));
}







?>