<?php
    class Database
    {
        private  $db_name="mysql:host=localhost;dbname=mobapi";
        private  $username="root";
        private  $password="";
        private  $conn;

        public $user;
        public $pass;

        public $dmin_id;
        public $category;

        public $category_id;
        public $product_id;
        public $product_size;
        public $product_name;
        public $product_desc;
        public $product_price;

        public $image_id;
        public $multipleImage=[];
       

       

        //database conn code
        public function __construct()
        {
            $this->conn=new PDO($this->db_name,$this->username,$this->password);
        }


       
    public function check_login()
    {
        $qry="select *from adminlogin where username=? and passwordd=?";
        $result=$this->conn->prepare($qry);

        $result->bindparam(1,$this->user);
        $result->bindparam(2,$this->pass);
        $result->execute();

        if($result->rowCount()>0)
        {
            
            return $result->fetch(PDO::FETCH_ASSOC);
           
        }
        else
        {
           return array();
        }
    }


    public function create_category()
    {
        $sql="insert into category_type(category_type) values (?)";
        $result1=$this->conn->prepare($sql);
        $category=htmlspecialchars(strip_tags($this->category));
        $result1->bindparam(1,$category);
       


        $result1->execute();
        if($result1->rowCount()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }



    public function create_product()
    {           
        $imagename=$_FILES['product_image']['name'];
        $extension=pathinfo($imagename,PATHINFO_EXTENSION);
        $image_name=rand() . ".".$extension;
        define('server_path',$_SERVER['DOCUMENT_ROOT'].'/mobapi/server/images/product_image/');
        define('image_path',server_path.$image_name);
        
      
        $trim_image=trim(image_path,'/home/lumbinis/');
      
       

        move_uploaded_file($_FILES['product_image']['tmp_name'],server_path.$image_name);
        $sql9="insert into product(category_id,product_name,product_size,product_price,product_image,product_desc) values (?,?,?,?,?,?)";
        $result9=$this->conn->prepare($sql9);
        $category_id=htmlspecialchars(strip_tags($this->category_id));
        $product_size=htmlspecialchars(strip_tags($this->product_size));
        $product_name=htmlspecialchars(strip_tags($this->product_name));
        $product_price=htmlspecialchars(strip_tags($this->product_price));
        $final=htmlspecialchars(strip_tags($trim_image));
        $product_desc=htmlspecialchars(strip_tags($this->product_desc));

        $result9->bindparam(1,$category_id);
        $result9->bindparam(2,$product_name);
        $result9->bindparam(3,$product_size);
        $result9->bindparam(4,$product_price);
        $result9->bindparam(5,$final);
        $result9->bindparam(6,$product_desc);

        $result9->execute();
        if($result9->rowCount()>0)
        {    
            return true;
        }               
        
    }
        
      
        
        


            public  function fetch_all_product_data()
            {
                $sql7="select *from product";

                $result7=$this->conn->prepare($sql7);
                $result7->execute();
                if($result7->rowCount()>0)
                {
                    $row=$result7->fetchall(PDO::FETCH_ASSOC);
                    return $row;
                    
                }
                else
                {
                    return false;
                }
            
                // $mul_image_query="select *from images";

                // $resultmul=$this->conn->prepare($mul_image_query);
                // $resultmul->execute();
                // if($resultmul->rowCount()>0)
                // {
                //    while($mul_image_row=$resultmul->fetchall(PDO::FETCH_ASSOC))
                //    {
                //      $mul_image_row;
                //    }
                   
                    
                // }
                // else
                // {
                //     return false;
                // }
            
            }   


            public function fetch_specific_data()
            {
                $sql3="select *from product  where id=?";
                $result3=$this->conn->prepare($sql3);
        
                $result3->bindparam(1,$this->product_id);
               
        
                $result3->execute();
                if($result3->rowCount()>0)
                {
                    $row=$result3->fetch(PDO::FETCH_ASSOC);
                    return $row;
                }
                else
                {
                    return false;
                }
            }


            


        public function update_product_info()
        {
            
            $imagename=$_FILES['image']['name'];
            $extension=pathinfo($imagename,PATHINFO_EXTENSION);
            $valid_extensions=array('png','jpg','jpeg');
            if(in_array($extension,$valid_extensions))
                {
                    $new_imagename=rand() . ".".$extension;
                
                
                  
                    define('server_path',$_SERVER['DOCUMENT_ROOT'].'/mobapi/server/images/product_image/');
                    define('image_path',server_path.$new_imagename);
                    $trim_image=trim(image_path,'/home/lumbinis/');

                    // $file_tmp=$_FILES['image']['tmp_name'];
                }
                if(move_uploaded_file($_FILES['image']['tmp_name'],server_path.$new_imagename))

                {
                    $sql9="update product set product_name=?,product_size=?,product_price=?,product_image=?,product_desc=? where id=?";
                    $result9=$this->conn->prepare($sql9);
    
                    $product_name=htmlspecialchars(strip_tags($this->product_name));
                    $product_size=htmlspecialchars(strip_tags($this->product_size));
                    $product_price=htmlspecialchars(strip_tags($this->product_price));
                    // $product_image=htmlspecialchars(strip_tags($this->product_image));
                    $product_desc=htmlspecialchars(strip_tags($this->product_desc));

                   
    
    
                    $result9->bindparam(1,$product_name);
    
                    $result9->bindparam(2,$product_size);
                    $result9->bindparam(3,$product_price);
                    $result9->bindparam(4,$trim_image);
                    $result9->bindparam(5,$product_desc);
                    $result9->bindparam(6,$this->product_id);


    
    
    
                    $result9->execute();
                    if($result9->rowCount()>0)
                    {
                        return true;
                     }               
                        
                     else{
                                 return false;
                                
                                
                        }     
    
    
                }
                else
                {
                    echo "sorryyyyyyyyyy";
                }
    
        }


        public function delete_product()
        {
             
            $sql11="DELETE FROM product WHERE id=?";
            
            $result11=$this->conn->prepare($sql11);
            $result11->bindparam(1,$this->product_id);
           
    
    
    
            $result11->execute();
            if($result11->rowCount()>0)
            {
                
                return true;
                
            }
            else
            {
                return false;
            }
    
        }
    
    
    
           

}


?>
