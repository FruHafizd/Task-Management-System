<?php
session_start();
include('../template/header.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                <div class="card">
                    <div class="card-header">
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/userControllers.php" method="post">
                            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {echo $_GET['token'];}?>">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" value="<?php 
                                if (isset($_GET['email'])) {
                                    echo $_GET['email'];
                                }?>" 
                                name="email" class="form-control" placeholder="Enter Your Email Address" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter Your New Password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Confim Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Your Password" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="password_update" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php'); ?>
