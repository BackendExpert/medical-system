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

            $channling_data = "INSERT INTO channeling_date_tbl(nic,ch_date,booked_date)VALUES('$nic','$next_ch_date',NOW())";
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
                                <a href=''><button class='btn btn-warning'><i class='fas fa-pen'></i> Edit</button></a>
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

        $p_nic = "SELECT * FROM patients_tbl WHERE id = '$id'";
        $p_id_result = mysqli_query($con, $p_nic);
        $p_nic_row = mysqli_fetch_assoc($p_id_result);

        echo $p_nic_row['nic'];      
        $_SESSION['patient_nic'] = $p_nic_row['nic'];    
    }


    //when check out btn click -> date autometically update and present pataient, checkout page, adding medi, body lang, and next chanaaling date
    // if not in given channeling date -> at 23:59 autometiclly absent and docter have to give new channling date
    //--> and make db and store new channaling date

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
                    Patient First Name :
                    <input type='text' class='form-control' value='".$patient_data_view['fname']."' disabled>
                </div>
            </div>

        
        ";

        echo $patient;

    }

?>