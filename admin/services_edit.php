<?php $title = 'Edit Service' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
$id = $_GET['id'];
$query = "SELECT * FROM services WHERE id = $id";
$result = mysqli_query($connection, $query);
$service = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $description = htmlspecialchars($_POST['description']);

    $query = "UPDATE services SET name = '$name', icon = '$icon', description = '$description' WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Service updated successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: services.php');
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Services</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="services.php">Services</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="services_edit.php?id=<?= $id ?>" method="POST">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon Class <span
                                            class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="icon" name="icon" required value="<?= $service['icon'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required  value="<?= $service['name'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?= $service['description'] ?></textarea>
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
