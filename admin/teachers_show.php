<?php $title = 'Teacher Details' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
$id = $_GET['id'];
$query = "SELECT teachers.id AS teacher_id, teachers.*, users.* FROM teachers JOIN users ON teachers.user_id = users.id WHERE teachers.id = $id";
$result = mysqli_query($connection, $query);
$teacher = mysqli_fetch_assoc($result);

// Approve Teacher
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $query = "UPDATE teachers SET approved = 1 WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Teacher approved successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: teachers_show.php?id=' . $id);
} else if (isset($_GET['disapprove'])) {
    $id = $_GET['disapprove'];
    $query = "UPDATE teachers SET approved = 0 WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Teacher disapproved successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: teachers_show.php?id=' . $id);
}

// Featured Teacher
if (isset($_GET['featured'])) {
    $id = $_GET['id'];
    $featured = $_GET['featured'];
    $query = "UPDATE teachers SET featured = $featured WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Teacher featured successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: teachers_show.php?id=' . $id);
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Teacher Details</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="teachers.php">Teachers</a>
                        </li>
                        <li class="breadcrumb-item active">Details</li>
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
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th style="width: 17%;">Image</th>
                                    <td>
                                        <?php if ($teacher['image']): ?>
                                        <img src="../uploads/<?= $teacher['image'] ?>" alt="Teacher Image">
                                        <?php else: ?>
                                        <img width="150" src="../images/person_placeholder.png" alt="Teacher Image">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?= $teacher['name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $teacher['email'] ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td><?= $teacher['mobile'] ? $teacher['mobile'] : 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?= $teacher['address'] ? $teacher['address'] : 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <th>Short Description</th>
                                    <td><?= $teacher['short_description'] ? $teacher['short_description'] : 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td><?= $teacher['description'] ? $teacher['description'] : 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <th>Featured</th>
                                    <td>
                                        <?php if ($teacher['featured']): ?>
                                            <span class="badge bg-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">No</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php if ($teacher['approved']): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            <?php if (!$teacher['approved']): ?>
                                <a href="teachers_show.php?id=<?= $teacher['teacher_id'] ?>&approve=<?= $teacher['teacher_id'] ?>" class="btn btn-success mt-3"
                                   onclick="return confirm('Are you sure?')">Approve <i class="bi bi-check-all"></i></a>
                            <?php else: ?>
                                <a href="teachers_show.php?id=<?= $teacher['teacher_id'] ?>&disapprove=<?= $teacher['teacher_id'] ?>" class="btn btn-warning mt-3"
                                   onclick="return confirm('Are you sure?')">Make Pending <i class="bi bi-x"></i></a>
                            <?php endif; ?>
                            <?php if (!$teacher['featured']): ?>
                                <a href="teachers_show.php?id=<?= $teacher['teacher_id'] ?>&featured=<?= 1 ?>" class="btn btn-success mt-3 ms-3"
                                   onclick="return confirm('Are you sure?')">Make Featured <i class="bi bi-check-all"></i></a>
                            <?php else: ?>
                                <a href="teachers_show.php?id=<?= $teacher['teacher_id'] ?>&featured=<?= 0 ?>" class="btn btn-warning mt-3 ms-3"
                                   onclick="return confirm('Are you sure?')">Remove From Featured <i class="bi bi-x"></i></a>
                            <?php endif; ?>
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
