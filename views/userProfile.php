<?php 
include('../template/header.php');
include('../controllers/authentication.php');
include('../controllers/userControllers.php');
include('../template/topbar.php');




$email = $_SESSION['auth_user']['user_id'];
$userControllers = new UserControllers();
$user = $userControllers->getUserById($email);

if (!$user) {
    $_SESSION['status'] = "Task not found.";
    header("Location: ../views/listTask.php");
    exit();
}
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Edit</h5>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/userControllers.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($user['email']) ?>">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control"value="<?= htmlspecialchars($user['email']) ?>" required readonly>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update_profile" class="btn btn-primary">Update Now</button>
                            </div>
                            <a href="password-reset.php">Here For Change Password</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php') ?>
