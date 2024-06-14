<?php $title = 'Students' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Student deleted successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: students.php');
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Students</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Students</li>
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
                            <div class="col-md-12 mb-4 d-flex flex-wrap justify-content-between align-items-center">
                                <div></div>
                                <!-- Search -->
                                <form action="" method="GET" class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." required value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <?php if (isset($_GET['search'])): ?>
                                        <a href="students.php" class="btn btn-danger"><i class="bi bi-x"></i></a>
                                    <?php endif; ?>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center">#</th>
                                            <th class="align-middle text-center">Student Name</th>
                                            <th class="align-middle text-center">Username</th>
                                            <th class="align-middle text-center">Email</th>
                                            <th class="align-middle text-center">Mobile</th>
                                            <th class="align-middle text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (isset($_GET['search'])) {
                                            $search = $_GET['search'];
                                            $query = "SELECT * FROM users WHERE role = 'student' AND (name LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%')";
                                        } else {
                                            $query = "SELECT * FROM users WHERE role = 'student'";
                                        }
                                        $students = mysqli_query($connection, $query);
                                        ?>
                                        <?php if(mysqli_num_rows($students) > 0): ?>
                                            <?php foreach ($students as $key => $students): ?>
                                                <tr>
                                                    <td class="align-middle text-center"><?= $key+1 ?></td>
                                                    <td class="align-middle text-center"><?= $students['name'] ?></td>
                                                    <td class="align-middle text-center"><?= $students['username'] ?></td>
                                                    <td class="align-middle text-center"><?= $students['email'] ?></td>
                                                    <td class="align-middle text-center"><?= $students['mobile'] ? $students['mobile'] : 'N/A' ?></td>
                                                    <td class="align-middle text-center">
                                                        <a href="students.php?delete=<?= $students['id'] ?>" class="btn btn-danger btn-sm"
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
