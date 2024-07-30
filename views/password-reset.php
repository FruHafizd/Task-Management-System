<?php
session_start();
include('../template/header.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                if (isset($_SESSION['status'])) {
                    ?>
                    <div class="alert alert-success">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                    <?php
                    unset($_SESSION['status']);
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        <h5>Reset Password</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="../controllers/userControllers.php" method="post">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="password_reset_link" class="btn btn-primary">Send Password Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php'); ?>
