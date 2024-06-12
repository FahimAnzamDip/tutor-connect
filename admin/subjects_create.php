<?php $title = 'Create Subject' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $subject_name = $_POST['subject_name'];

    $query = "INSERT INTO subjects (subject_name) VALUES ('$subject_name')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Subject created successfully!';
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
                        <li class="breadcrumb-item">
                            <a href="subjects.php">Subjects</a>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="subjects_create.php" method="POST">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Create
                                <i class="bi bi-check-all"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content End -->
    </div>
</section>
<!-- Content End -->

<?php include_once '../includes/admin_footer.php' ?>
