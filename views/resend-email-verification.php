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
                        <h5>Resend Email Verification</h5>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/userControllers.php" method="post">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Your Email Address" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php'); ?>
