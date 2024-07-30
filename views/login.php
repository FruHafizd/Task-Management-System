<?php 
session_start();

if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Logged in";
    header("Location: ../views/index.php");
    exit(0);
} else {
    # code...
}
include('../template/header.php');
?>
    
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="alert">
                    <?php 
                    if (isset($_SESSION['status']))
                    {
                        ?>
                        <div class="alert alert-succes">
                            <h4><?=$_SESSION['status']?></h4>
                        </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                    ?>
                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/userControllers.php" method="post">
                            <div class="form-group mb-3">
                                <label for="">Email Addres </label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="login_now_btn">Login Now</button>
                            </div>
                        </form>
                        <a href="register.php">REGISTER HERE</a> |
                        <a href="resend-email-verification.php">RESEND EMAIL VERIFICATION</a> | 
                        <a href="password-reset.php">FORGOT PASSWORD?</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php')?>