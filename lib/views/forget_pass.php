<?php include("../layouts/header.php") ?>
<?php include("../function/function.php"); ?>

<link rel="stylesheet" href="../../css/style.css">

<div class="container">
<div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="card login-card">
                <div class="card-header">
                    <h4><i class="fas fa-user-shield"></i>  Password Reset</h4>
                </div>
                <div class="card-body login-body">
                    <?php 

                    ?>

                    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <h5>Enter Email Address</h5>
                        <p>Email : </p>
                        <input type="email" name="email" id="" class="form-control" placeholder="Email" required></p>

                        <input type="submit" value="Request OTP" class="btn btn-primary" name="get_otp">
                    </form>
                    <br>
                    <p><a href="../../index.php">Back</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
</div>
</div>

