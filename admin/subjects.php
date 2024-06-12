<?php $title = 'Subjects' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM subjects WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Subject deleted successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: subjects.php');
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Subjects</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Subjects</li>
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
                            <div class="col-md-12 mb-4">
                                <a href="subjects_create.php" class="btn btn-primary">
                                    <i class="bi bi-plus"></i>
                                    Add Subject
                                </a>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center">#</th>
                                            <th class="align-middle text-center">Subject Name</th>
                                            <th class="align-middle text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = "SELECT * FROM subjects";
                                        $subjects = mysqli_query($connection, $query);
                                        ?>
                                        <?php if(mysqli_num_rows($subjects) > 0): ?>
                                            <?php foreach ($subjects as $key => $subject): ?>
                                                <tr>
                                                    <td class="align-middle text-center"><?= $key++ ?></td>
                                                    <td class="align-middle text-center"><?= $subject['subject_name'] ?></td>
                                                    <td class="align-middle text-center">
                                                        <a href="subjects_edit.php?id=<?= $subject['id'] ?>" class="btn btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="subjects.php?delete=<?= $subject['id'] ?>" class="btn btn-danger btn-sm"
                                                           onclick="return confirm('Are you sure?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="align-middle text-center text-danger">No data found!</td>
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
