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
                            <div class="col-md-12 mb-4">
                                <a href="teachers_create.php" class="btn btn-primary">
                                    <i class="bi bi-plus"></i>
                                    Add Teacher
                                </a>
                            </div>
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
                                            <th class="align-middle text-center">Subjects</th>
                                            <th class="align-middle text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = "SELECT * FROM teachers";
                                        $teachers = mysqli_query($connection, $query);
                                        ?>
                                        <?php if(mysqli_num_rows($teachers) > 0): ?>
                                            <?php foreach ($teachers as $key => $teacher): ?>
                                                <tr>
                                                    <td class="align-middle text-center"><?= $key++ ?></td>
                                                    <td class="align-middle text-center">
                                                        <img src="../uploads/teachers/<?= $teacher['image'] ?>" alt="<?= $teacher['name'] ?>" class="rounded-circle" width="50">
                                                    </td>
                                                    <td class="align-middle text-center"><?= $teacher['name'] ?></td>
                                                    <td class="align-middle text-center"><?= $teacher['email'] ?></td>
                                                    <td class="align-middle text-center"><?= $teacher['mobile'] ?></td>
                                                    <td class="align-middle text-center">
                                                        <?php
                                                        $teacher_id = $teacher['id'];
                                                        $query = "SELECT subjects.subject_name FROM subjects JOIN teacher_subject ON subjects.id = teacher_subject.subject_id WHERE teacher_subject.teacher_id = $teacher_id";
                                                        $subjects = mysqli_query($connection, $query);
                                                        ?>
                                                        <?php if(mysqli_num_rows($subjects) > 0): ?>
                                                            <?php foreach ($subjects as $subject): ?>
                                                                <span class="badge bg-primary"><?= $subject['subject_name'] ?></span>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">No Subject</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="teachers_edit.php?id=<?= $teacher['id'] ?>" class="btn btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="teachers.php?delete=<?= $teacher['id'] ?>" class="btn btn-danger btn-sm"
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
