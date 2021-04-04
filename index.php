<?php
/**
 * Index Page
 * 
*/

include 'database.php';
$obj = new database();

/**Inser Data */
if(isset($_POST['submit'])){
    $obj->insertData($_POST);
}

/**Update Data */
if(isset($_POST['update'])){
    $obj->updateData($_POST);
}

/**Delete Data */
if(isset($_GET['deleteid'])){
    $delid = $_GET['deleteid'];
    $obj->deleteData($delid);
}

/**Upload CSV */
if(isset($_POST['upload'])){
    $obj->uploadCsv($_POST);
}

?>
<!DOCTYPE html>
<html>
    <head>
    
        <title>CRUD App</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- CUstom Css -->
        <link rel="stylesheet" href="style.css" />

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        
    </head>
    <body>
        <h1 class="text-center crud-h1">CRUD Application</h1>
        <div class="container">

            <?php
            /**
             * Success Message
             */

             if(isset($_GET['msg']) && $_GET['msg']=='ins'){
                 echo '<div class="alert alert-primary role=alert">
                    EMployee Record Inserted!!
                 </div>';
             }
             if(isset($_GET['msg']) && $_GET['msg']=='ups'){
                echo '<div class="alert alert-primary role=alert">
                    EMployee Record Updated!!
                </div>';
             }

            ?>

            <!-- Update Employe Data --------------------------------------------->
            
            <?php

            if(isset($_GET['editid'])){
                $editid = $_GET['editid'];
                $records = $obj->displayDataById($editid);
                $hobbies_data = $records['hobbies'];
                $hobbies_check_value = explode(',',$hobbies_data);
                $date_new = $records['jdate'];
                
                
            ?>

            
            

            
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" placeholder="Enter you first name" class="form-control" value="<?php echo $records['fname']; ?>" />
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" placeholder="Enter you last name" class="form-control" value="<?php echo $records['lname']; ?>" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Enter you email address" class="form-control" value="<?php echo $records['email']; ?>" />
                </div>
                <div class="checkbox-hobbies">
                    <label>Hobbies</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-tv" name="hobbie[]" value="tv"
                    <?php
                        if(in_array('tv',$hobbies_check_value)){
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="hobbies-tv">TV</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-reading" name="hobbie[]" value="reading"
                    <?php
                        if(in_array('reading',$hobbies_check_value)){
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="hobbies-reading">Reading</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-coding" name="hobbie[]" value="coding"
                    <?php
                        if(in_array('coding',$hobbies_check_value)){
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="hobbies-coding">Coding</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-skiing" name="hobbie[]" value="skiing"
                    <?php
                        if(in_array('skiing',$hobbies_check_value)){
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="hobbies-skiing">Skiing</label>
                </div>
                <div class="radio-gender">
                    <label>Gender</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male-radio" value="male"
                    <?php
                        if($records['gender']=='male'){
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="male-radio">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female-radio" value="female"
                    <?php
                        if($records['gender']=='female'){
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="female-radio">Female</label>
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" value="<?php echo date($date_new); ?>">
                </div>
                <div class="dropdown">
                    <label for="department">Department:</label>
                        <select name="department" id="department">
                            <option value="hr" 
                            <?php
                                if($records['department']=='hr'){
                                    echo 'selected';
                                }
                            ?>
                            >HR</option>
                            <option value="admin"
                            <?php
                                if($records['department']=='admin'){
                                    echo 'selected';
                                }
                            ?>
                            >Admin</option>
                            <option value="marketing"
                            <?php
                                if($records['department']=='marketing'){
                                    echo 'selected';
                                }
                            ?>
                            >Marketing</option>
                            <option value="production"
                            <?php
                                if($records['department']=='production'){
                                    echo 'selected';
                                }
                            ?>
                            >Production</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="img">Update Picture:</label>
                    <img src="image/<?php echo $records['picture'] ?>" width="100px" height="100px"/>
                    <input type="file" id="img" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <input type="hidden" name="hid" value="<?php echo $records['id']; ?>" />
                    <input type="submit" name="update" value="Update" class="btn btn-info">
                </div>
            </form>


            <?php    
            }
            else{

            ?>
            

            <!------------------------------------------------------------------------------------ -->


            <!-- Insert Employeee Data --> 

            <form name="eForm" action="index.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" >
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" placeholder="Enter you first name" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" placeholder="Enter you last name" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Enter you email address" class="form-control" required/>
                </div>
                <div class="checkbox-hobbies">
                    <label>Hobbies</label>
                </div>
                <div class="form-check form-check-inline ">
                    <input class="form-check-input" type="checkbox" id="hobbies-tv" name="hobbie[]" value="tv" >
                    <label class="form-check-label" for="hobbies-tv">TV</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-reading" name="hobbie[]" value="reading" >
                    <label class="form-check-label" for="hobbies-reading">Reading</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-coding" name="hobbie[]" value="coding" >
                    <label class="form-check-label" for="hobbies-coding">Coding</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobbies-skiing" name="hobbie[]" value="skiing" >
                    <label class="form-check-label" for="hobbies-skiing">Skiing</label>
                </div>
                <div class="radio-gender">
                    <label>Gender</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male-radio" value="male" >
                    <label class="form-check-label" for="male-radio">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female-radio" value="female" >
                    <label class="form-check-label" for="female-radio">Female</label>
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" required>
                </div>
                <div class="dropdown">
                    <label for="department">Department:</label>
                        <select name="department" id="department" required>
                            <option>Select One</option>
                            <option value="hr">HR</option>
                            <option value="admin">Admin</option>
                            <option value="marketing">Marketing</option>
                            <option value="production">Production</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="img">Upload Picture:</label>
                    <input type="file" id="img" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Submit" class="btn btn-info">
                </div>
            </form>

            <?php }  ?>


            <br>

             <!-- Display Employee Data ------------------------------------------------->
        </div>     
        <div class="container-fluid">

            <h2 class="text-center crud-h2">All Employee Records</h2>

             <!-- Upload CSV------------------->
            
             <form method="POST" enctype="multipart/form-data" class="text-center ">
                <div class="form-group">
                    <label>Upload CSV: </label>
                    <input type="file" name="file"/>
                    <input type="submit" name="submit" value="Import" class="btn btn-primary"/>
                </div>
            </form>

            <!-- -------------------->

            <?php
                if(isset($_GET['msg']) && $_GET['msg']=='del'){
                    echo '<div class="alert alert-primary role=alert">
                       Employee Record Deleted!!
                    </div>'; 
                 }
            ?>
            <table class="table table-bordered">
                <tr class="text-center ">
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Hobbies</th>
                    <th>Gender</th>
                    <th>Joining Date</th>
                    <th>Department</th>
                    <th>Picture</th>
                    <th>Action</th>
                </tr>
                <?php
                $data = $obj->displayData();
                $no=1;
                foreach($data as $value){
                 ?>
                    
                    <tr class="text-center">
                        <th><?php echo $no++; ?></th>
                        <th><?php echo $value['fname'] ?></th>
                        <th><?php echo $value['lname'] ?></th>
                        <th><?php echo $value['email'] ?></th>
                        <th><?php echo $value['hobbies']?></th>
                        <th><?php echo $value['gender']?></th>
                        <th><?php echo $value['jdate']?></th>
                        <th><?php echo $value['department']?></th>
                        <th><img src="image/<?php echo $value['picture'] ?>" width="50px" height="50px"/></th>
                        <th>
                            <a href="index.php?editid=<?php echo $value['id'] ?>" class="btn btn-info">Edit</a>
                            
                            <a href="#myModal" class="trigger-btn btn btn-danger" data-toggle="modal">Delete</a>

                            <!--<a href="index.php?deleteid=<?php echo $value['id']?>" class="btn btn-danger">Delete</a>-->
                        </th>
                    </tr>
                    
                    <?php   
                }    
                ?>
            </table>


            <!-- Delete Conformation Popup-->


            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header flex-column">
                            <div class="icon-box">
                                <i class="material-icons">&#xE5CD;</i>
                            </div>						
                            <h4 class="modal-title w-100">Are you sure?</h4>	
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a href="index.php?deleteid=<?php echo $value['id']?>" class="btn btn-danger conf-delete">Delete</a>
                        </div>
                    </div>
                </div>
            </div>     


            <!--------------------------------------------------------- -->

        </div>
    </body>
</html>
