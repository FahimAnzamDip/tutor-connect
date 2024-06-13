<?php $title = 'Teachers' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM teachers WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Teacher deleted successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: teachers.php');
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Teachers</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content Start -->
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                        <?php unset($_SESSION['error']) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']) ?>
                    </div>
                <?php endif; ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center">#</th>
                                            <th class="align-middle text-center">Image</th>
                                            <th class="align-middle text-center">Teacher Name</th>
                                            <th class="align-middle text-center">Email</th>
                                            <th class="align-middle text-center">Mobile</th>
                                            <th class="align-middle text-center">Featured</th>
                                            <th class="align-middle text-center">Status</th>
                                            <th class="align-middle text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = "SELECT teachers.id AS teacher_id, teachers.*, users.* FROM teachers JOIN users ON teachers.user_id = users.id";
                                        $teachers = mysqli_query($connection, $query);
                                        ?>
                                        <?php if(mysqli_num_rows($teachers) > 0): ?>
                                            <?php foreach ($teachers as $key => $teacher): ?>
                                                <tr>
                                                    <td class="align-middle text-center"><?= $key+1 ?></td>
                                                    <td class="align-middle text-center">
                                                        <?php if ($teacher['image']): ?>
                                                        <img src="../uploads/<?= $teacher['image'] ?>" alt="<?= $teacher['name'] ?>" class="rounded-circle" width="50">
                                                        <?php else: ?>
                                                        <img src="../images/person_placeholder.png" alt="<?= $teacher['name'] ?>" class="rounded-circle" width="50">
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="align-middle text-center"><?= $teacher['name'] ?></td>
                                                    <td class="align-middle text-center"><?= $teacher['email'] ?></td>
                                                    <td class="align-middle text-center"><?= $teacher['mobile'] ? $teacher['mobile'] : 'N/A' ?></td>
                                                    <td class="align-middle text-center">
                                                        <?php if ($teacher['featured']): ?>
                                                            <span class="badge bg-success">Yes</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">No</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <?php if ($teacher['approved']): ?>
                                                            <span class="badge bg-success">Approved</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning">Pending</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="teachers_show.php?id=<?= $teacher['teacher_id'] ?>" class="btn btn-info btn-sm">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="teachers.php?delete=<?= $teacher['teacher_id'] ?>" class="btn btn-danger btn-sm"
                                                           onclick="return confirm('Are you sure?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="align-middle text-center text-danger">No data found!</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content End -->
    </div>
</section>
<!-- Content End -->

<?php include_once '../includes/admin_footer.php' ?>
