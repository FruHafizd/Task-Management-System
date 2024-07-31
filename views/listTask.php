<?php 
include('../template/header.php');
include('../controllers/authentication.php');
include('../model/tasks.php');
include('../template/topbar.php');
?>

<section class="container justify-content-center mt-5">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="example" style="width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Due date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;                    
                        $tasks = new Tasks();
                        $result = $tasks->displayTask();
                        while ($data = $result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><?= $no++;  ?></td>
                        <td><?= $data['title'] ?></td>
                        <td><?= $data['description'] ?></td>
                        <td><?= $data['due_date'] ?></td>
                        <td><?= $data['status'] ?></td>
                        <td>
                            <a href="updateTask.php?id=<?= $data['id'] ?>" class="btn btn-success" style="color: white;">Edit</a>
                            <a href="proses?id=<?= $data['id'] ?>" class="btn btn-danger" style="color: white;">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php 
include('../template/footer.php');
?>

<!-- CSS tambahan untuk margin atas container -->
<style>
    .container {
        margin-top: 20px;
    }
</style>

