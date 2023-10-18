<?php 
    include("config.php");
    use FTP\Connection;
    session_start();

    function sign_up($username, $email, $pass, $cpass){
        $con = Connection();

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Email : </strong> invalid Email...!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        elseif($pass != $cpass){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Password Error : </strong> Password and Confirm Password not match...!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
        else{
            $check_user = "SELECT * FROM user_tbl WHERE email = '$email' || username = '$username'";
            $check_user_result = mysqli_query($con, $check_user);
            $check_user_nor = mysqli_num_rows($check_user_result);

            if($check_user_nor > 0){
                return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>User : </strong> already exists...!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }

            else{

                $insert_user = "INSERT INTO user_tbl(username,email,user_pass,user_type,is_active,u_access,join_at,update_at)VALUES('$username','$email','$pass','user',0,0,NOW(),NOW())";
                $insert_user_result = mysqli_query($con, $insert_user);

                if($insert_user_result){
                    header("location:../../index.php");
                }
                elseif(!$check_user_result){
                    return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>ERROR : </strong> 
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            }
        }        
    }

    function sign_in($username, $pass){
        $con = Connection();

        $check_login_user = "SELECT * FROM user_tbl WHERE username = '$username' && user_pass = '$pass'";
        $check_login_user_result = mysqli_query($con, $check_login_user);
        $check_login_user_nor = mysqli_num_rows($check_login_user_result);
        $check_login_user_row = mysqli_fetch_assoc($check_login_user_result);

        if($check_login_user_nor > 0){
            if($pass == $check_login_user_row['user_pass']){
                if(($check_login_user_row['user_type'] == 'user')){
                    setcookie('login',$check_login_user_row['email'],time()+60*60,'/');
                    $_SESSION['loginSession'] = $check_login_user_row['email'];
                    header("location:lib/routes/user.php");
                }
                elseif($check_login_user_row['user_type'] == 'admin'){
                    setcookie('login',$check_login_user_row['email'],time()+60*60,'/');
                    $_SESSION['loginSession'] = $check_login_user_row['email'];
                    header("location:lib/routes/admin.php");
                }
            }
            else{
                return "<center>&nbsp<div class='alert alert-danger col-10' role='alert'>Password is Doesn't Match...!</div>&nbsp</center>"; 
            }
        }
        else{
            return "<center>&nbsp<div class='alert alert-danger col-10' role='alert'>No recodes found..!</div>&nbsp</center>"; 
        }

    }

    function add_patient($nic, $pfname, $plname, $pgender, $pmobile, $paddress, $medi, $next_ch_date){
        $con = Connection();

        $check_patients = "SELECT * FROM patients_tbl WHERE nic = '$nic'";
        $check_patients_result = mysqli_query($con, $check_patients);
        $check_patients_nor = mysqli_num_rows($check_patients_result);

        if($check_patients_nor <= 0){
            $insert_patient = "INSERT INTO patients_tbl(nic,fname,lname,gender,mobile_no,address,join_at,update_at)VALUES('$nic','$pfname','$plname','$pgender','$pmobile','$paddress',NOW(), NOW())";
            $insert_patient_result = mysqli_query($con, $insert_patient);

            $channling_data = "INSERT INTO channeling_date_tbl(nic,ch_date,booked_date,channel_status)VALUES('$nic','$next_ch_date',NOW(),0)";
            $channling_data_result = mysqli_query($con, $channling_data);

            $insert_medicine = "INSERT INTO medicine_tbl(nic,medicine,add_date)VALUES('$nic','$medi',NOW())";
            $insert_medicine_result = mysqli_query($con, $insert_medicine);

            echo "
            <script>
                window.location = '../patients.php';
            </script>
            ";

        }
        else{
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>ERROR: </strong> Patient Already Exists....!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
    }

    function all_patients(){
        $con = Connection();

        $all_patients = "SELECT * FROM patients_tbl";
        $all_patients_result = mysqli_query($con, $all_patients);


        $is_table_empty = "SELECT COUNT(*) as id FROM patients_tbl";
        $is_table_empty_result = mysqli_query($con, $is_table_empty);

        //55555555555555555555
        if($is_table_empty_result){
            $empty_row = mysqli_fetch_assoc($is_table_empty_result);
            $id_count = $empty_row['id'];

            if($id_count == 0){
                echo "Table is Empty";
            }
            else{
                while($row = mysqli_fetch_assoc($all_patients_result)){
                    $patient = "
                        <tr>
                            <td>".$row['nic']."</td>
                            <td>".$row['fname']."</td>
                            <td>".$row['join_at']."</td>";

                            if($row['gender'] == "male"){
                                $patient .="<td><i class='fas fa-male'></i> Male </td>";
                            }
                            elseif($row['gender'] == "female"){
                                $patient .="<td><i class='fas fa-female'></i> Female </td>";
                            }

                            $patient .="
                            <td>
                                <a href='patient/show.php?id=".$row['id']."'><button class='btn btn-info'><i class='fas fa-eye'></i> View</button></a>
                            </td>

                        </tr>
                    ";

                    echo $patient;
                }   

            }
        }
    }

    function count_users(){
        $con = Connection();

        $count_user = "SELECT * FROM user_tbl";
        $count_user_result = mysqli_query($con, $count_user);
        $count_user_nor = mysqli_num_rows($count_user_result);

        echo $count_user_nor;
    }

    function count_patient(){
        $con = Connection();

        $count_patients = "SELECT * FROM patients_tbl";
        $count_patients_result = mysqli_query($con, $count_patients);
        $count_patients_nor = mysqli_num_rows($count_patients_result);

        echo $count_patients_nor;
    }


    function patient_nic(){
        $con = Connection();

        $id = $_GET['id'];

        $_SESSION['patient_id_back'] = $id;

        $p_nic = "SELECT * FROM patients_tbl WHERE id = '$id'";
        $p_id_result = mysqli_query($con, $p_nic);
        $p_nic_row = mysqli_fetch_assoc($p_id_result);

        echo $p_nic_row['nic'];      
        $_SESSION['patient_nic'] = $p_nic_row['nic'];    
    }

    function patient_id(){
        $con = Connection();

        $patient_nic = $_GET['id'];
        echo $patient_nic;

        $_SESSION['edit_patient'] = $patient_nic;

    }

    function edit_patient_back(){
        $con = Connection();
        
        $p_nic = strval($_SESSION['patient_nic']);

        $select_id = "SELECT * FROM patients_tbl WHERE nic='$p_nic'";
        $select_id_result = mysqli_query($con, $select_id);
        $select_id_row = mysqli_fetch_assoc($select_id_result);

        echo $select_id_row['id'];        

    }



    function show_patient(){
        $con = Connection();

        $patient_id = strval($_SESSION['patient_nic']);
        // echo $patient_id;

        $patient_data = "SELECT * FROM patients_tbl WHERE nic = '$patient_id'";
        $patient_data_result = mysqli_query($con, $patient_data);
        $patient_data_view = mysqli_fetch_assoc($patient_data_result);

        $patient = "
            <h2>Patient Data : ".$patient_data_view['nic']."</h2>
            <hr>

            <div class='row'>
                <div class='col-lg-5'>
                    Patient NIC : 
                    <input type='text' class='form-control' value='".$patient_data_view['nic']."' disabled>
                </div>
                <div class='col-lg-1'>&nbsp;&nbsp;&nbsp;</div>
                <div class='col-lg-6'>
                    Patient First Name :
                    <input type='text' class='form-control' value='".$patient_data_view['fname']."' disabled>
                </div>
            </div>
            <br>
            <div class='row'>
                <div class='col-lg-5'>
                    Patient Gender : ";

                    if($patient_data_view['gender'] == "male"){
                        $patient .= "<h3><i class='fas fa-male'></i> Male</h3>";
                    }
                    elseif($patient_data_view['gender'] == "female"){
                        $patient .= "<h3><i class='fas fa-female'></i> Female</h3>";
                    }
            
            $patient .="        
                </div>
                <div class='col-lg-1'>&nbsp;&nbsp;&nbsp;</div>
                <div class='col-lg-6'>
                    Patient Last Name :
                    <input type='text' class='form-control' value='".$patient_data_view['lname']."' disabled>
                </div>
            </div>
            <br>
            <div class='row'>
                <div class='col-lg-5'>
                    Patient Mobile : 
                    <input type='text' class='form-control' value='".$patient_data_view['mobile_no']."' disabled>
                </div>
                <div class='col-lg-1'>&nbsp;&nbsp;&nbsp;</div>
                <div class='col-lg-6'>
                    Patient First Date :
                    <input type='text' class='form-control' value='".$patient_data_view['join_at']."' disabled>
                </div>
            </div>
            <hr>        
        ";

        $medi_info = "SELECT * FROM medicine_tbl WHERE nic = '$patient_id'";
        $medi_info_result = mysqli_query($con, $medi_info);
        $medi_info_view = mysqli_fetch_assoc($medi_info_result);

        $patient .= "
            <div class='row'>
                <div class='col-lg-12'>
                    Given Medicine : 
                    <textarea class='form-control pAddress' disabled>".$medi_info_view['medicine']."</textarea>
                </div>
            </div>
            <br>
            <div class='row'>
                <div class='col-lg-12'>
                    Given Date : 
                    <input type='text' class='form-control' value='".$medi_info_view['add_date']."' disabled> 
                </div>
            </div>
            <hr>
        ";

        $next_ch_date = "SELECT * FROM channeling_date_tbl WHERE nic = '$patient_id'";
        $next_ch_date_result = mysqli_query($con, $next_ch_date);
        $view_next_ch_date = mysqli_fetch_assoc($next_ch_date_result);

        $patient .= "
            <div class='row'>
                <div class='col-lg-12'>
                    Next Channeling Date : 
                    <input type='text' class='form-control' value='".$view_next_ch_date['ch_date']."' disabled>
                </div>
            </div>
            <br><br>
        ";

        echo $patient;

    }

    function edit_patient_data(){
        $con = Connection();

        $nic_patient = strval($_SESSION['edit_patient']);

        $get_patient = "SELECT * FROM patients_tbl WHERE nic = '$nic_patient'";
        $get_patient_result = mysqli_query($con, $get_patient);

        $patient_data = mysqli_fetch_assoc($get_patient_result);

        $patient_edit = "
            <form action='' method='POST'>
                <div class='row'>
                    <div class='col-lg-6'>
                        Patient NIC : 
                        <input type='text' class='form-control' value='".$patient_data['nic']."' disabled> 
                        <input type='hidden' name='id_patient' value='".$patient_data['nic']."'>
                    </div>
                    <div class='col-lg-1'>&nbsp;&nbsp;&nbsp;</div>
                    <div class='col-lg-5'>
                        Patient First Name : 
                        <input type='text' class='form-control' value='".$patient_data['fname']."' disabled>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-lg-6'>";

                        if($patient_data['gender'] == 'male'){
                            $patient_edit .= "<h3><i class='fas fa-male'></i> Male </h3>";
                        }
                        elseif($patient_data['gender'] == 'female'){
                            $patient_edit .="<h3><i class='fas fa-female'></i> Female </h3>";
                        }

     $patient_edit .= "</div>
                    <div class='col-lg-1'>&nbsp;&nbsp;&nbsp;&nbsp;</div>

                    <div class='col-lg-5'>
                        Patient Last Name : 
                        <input type='text' class='form-control' value='".$patient_data['lname']."' disabled>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-lg-6'>
                        Patient Mobile : 
                        <input type='text' name='new_mobile' class='form-control' value='".$patient_data['mobile_no']."' required>
                    </div>
                    <div class='col-lg-1'>&nbsp;&nbsp;&nbsp;</div>
                    <div class='col-lg-5'>
                        Patient First Date :
                        <input type='text' class='form-control' value='".$patient_data['join_at']."' disabled>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-lg-12'>
                        <input type='submit' name='update_patient' value='Update Patient' class='btn btn-primary'>
                    </div>
                </div>
            </form>
        
        ";

        echo $patient_edit;

    }

    function update_patient($patient_nic, $patient_mobile){
        $con = Connection();

        $update_patient_mobile = "UPDATE patients_tbl SET mobile_no = '$patient_mobile' WHERE nic='$patient_nic'";
        $update_patient_mobile_result = mysqli_query($con, $update_patient_mobile);
        echo "
        <script>
            window.location = '../patients.php';
        </script>
        ";
    }

?>