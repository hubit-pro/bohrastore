<?php
ini_set("display_errors",1);
include('../../vendor/autoload.php');
use \Firebase\JWT\JWT;
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:PUT');
header("Access-Control-Allow-Headers:Content-Type,Authorization");
include('../../database/database.php');
$database_obj=new Database();
if($_SERVER['REQUEST_METHOD']==="PUT")
    {
        $data=json_decode(file_get_contents("php://input"));
        $headers=getallheaders();
        $database_obj->passwordd=$data->password;
        $database_obj->cpasswordd=$data->cpassword;
        if($database_obj->passwordd==$database_obj->cpasswordd)
        {
            if($database_obj->update_password())
            {
                http_response_code(200);
                echo json_encode(array(
                "status"=>1,
                "message"=>"password has been updated"
                    ));
            }
            else
            {
                http_response_code(500);
                echo  json_encode(array(
                "status"=>0,
                "message"=>"sorry,something went wrong"

                ));
            }

        }
        else
        {   
            http_response_code(500);
                echo  json_encode(array(
                "status"=>0,
                "message"=>"password and confirm password does not match"

                ));

        }

        



    }
















?>