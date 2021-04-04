<?php

/**
 * database 
 * 
 */

class database {

    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'employee';
    private $connection ;

    /**establish connecttion to db */

    function __construct()
    {
        $this->connection = new mysqli($this->servername,$this->username,$this->password,$this->dbname);

        if($this->connection->connect_error){
            echo 'Failed to connect';
        }
        else{
            return $this->connection;
        }
    }

    /**Insert Data */

    public function insertData($post){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $hobbies = $_POST['hobbie'];
        $hobbies_checkbox = implode(",",$hobbies);
        $gender = $_POST['gender'];
        $jdate = date('Y-m-d', strtotime($_POST['birthday']));
        $department = $_POST['department'];
        
        $file = $_FILES['image']['name'];

        $sql = "INSERT INTO employee(fname,lname,email,hobbies,gender,jdate,department,picture)VALUES('$fname','$lname','$email','$hobbies_checkbox','$gender','$jdate','$department','$file')";
        $result = $this->connection->query($sql);

        if($result){
            move_uploaded_file($_FILES['image']['tmp_name'], "image/$file");
        }

        if($result){
            header('location:index.php?msg=ins');
        }
        else{
            echo 'Error '.$sql.'<br>'.$this->connection->error;
        }
    }
    /**---------------------------------------------------- */

    /**Upload CSV ----------------------------------------- */

    public function uploadCsv($post){
        if($_FILES['submit']){
            $filename = explode(".",$_FILES['file']['name']);
            if($filename[1] == 'csv'){
                $handle = fopen($_FILES['file']['tmp_name'],'r');
                while($data = fgetcsv($handle)){
                    $fname = mysqli_real_escape_string($this->connection,$data[0]);
                    $lname = mysqli_real_escape_string($this->connection,$data[1]);
                    $email = mysqli_real_escape_string($this->connection,$data[2]);
                    $hobbies = mysqli_real_escape_string($this->connection,$data[3]);
                    $gender = mysqli_real_escape_string($this->connection,$data[4]);
                    $jdate = mysqli_real_escape_string($this->connection,$data[5]);
                    $department = mysqli_real_escape_string($this->connection,$data[6]);

                    $sql = "INSERT INTO employee (fname,lname,email,hobbies,gender,jdate,department)VALUES('$fname','$lname','$email','$hobbies','$gender','$jdate','$department')";

                    $result = $this->connection->query($sql);

                    if($result){
                        header('location:index.php?msg=ins');
                    }
                    else{
                        echo 'Error '.$sql.'<br>'.$this->connection->error;
                    }
                }
                fclose($handle);
            }
        }
    }

    /**------------------------------------------------------ */


    /**Update Data ----------------------------------------- */

    public function updateData($post){
        $hid = $_POST['hid'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $hobbies = $_POST['hobbie'];
        $hobbies_checkbox = implode(",",$hobbies);
        $gender = $_POST['gender'];
        $jdate = date('Y-m-d', strtotime($_POST['birthday']));
        $department = $_POST['department'];
        
        $file = $_FILES['image']['name'];

        $sql = "UPDATE employee SET fname='$fname',lname='$lname',email='$email',hobbies='$hobbies_checkbox',gender='$gender',jdate='$jdate',department='$department',picture='$file' WHERE id='$hid'";
        $result = $this->connection->query($sql);

        if($result){
            move_uploaded_file($_FILES['image']['tmp_name'], "image/$file");
        }

        if($result){
            header('location:index.php?msg=ups');
        }
        else{
            echo 'Error '.$sql.'<br>'.$this->connection->error;
        }
    }

    /**----------------------------------------------------------- */

    /**DisplaY Records */

    public function displayData(){

        $sql = "SELECT * FROM employee";
        $result = $this->connection->query($sql);

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }

    /***-------------------------------------------------------- */

    /** Update Records */

    public function displayDataById($editid){
        $sql = "SELECT * FROM employee WHERE id = '$editid'";
        $result = $this->connection->query($sql);
        if($result->num_rows==1){
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    /**--------------------------------------------------------- */

    /** Delete Records ------------------------------------- */

    public function deleteData($delid){
        $sql = "DELETE FROM employee WHERE id='$delid'";
        $result = $this->connection->query($sql);
        if($result){
            header('location:index.php?msg=del');
        }
        else{
            echo 'Error '.$sql.'<br>'.$this->connection->error;
        }
    }

    /**---------------------------------------------------------- */

}

?>