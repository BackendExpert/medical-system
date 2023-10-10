<?php include("../layouts/header.php") ?>
<?php include("../function/function.php"); ?>

<link rel="stylesheet" href="../../css/style.css">

<div class="container">
<div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="card login-card">
                <div class="card-header">
                    <h4><i class="fas fa-user-plus"></i>  Sign Up Here</h4>
                </div>
                <div class="card-body login-body">
                    <?php 
                        if(isset($_POST['sign_up'])){
                            $result = sign_up($_POST['username'], $_POST['email'], md5($_POST['password']), md5($_POST['cpassword']));
                            echo $result;
                        }
                    ?>

                    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <p>Username : </p>
                        <input type="text" name="username" id="" class="form-control" placeholder="Username" required></p>

                        <p>Email : </p>
                        <input type="email" name="email" id="" class="form-control" placeholder="Email" required></p>

                        <p>Password : </p>
                        <input type="password" name="password" id="" class="form-control" placeholder="Password" required></p>

                        <p>Confirm Password : </p>
                        <input type="password" name="cpassword" id="" class="form-control" placeholder="Confirm Password" required></p>

                        <input type="submit" value="Sign Up" class="btn btn-primary" name="sign_up">
                    </form>
                    <br>
                    <p>Don't have an Account ? <a href="../../index.php">Sign In</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
</div>
</div>

