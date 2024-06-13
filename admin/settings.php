<?php $title = 'Edit Settings' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
$id = 1;
$query = "SELECT * FROM settings WHERE id = $id";
$result = mysqli_query($connection, $query);
$settings = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $site_name = $_POST['site_name'];
    $about_title = trim($_POST['about_title']);
    $about_content = trim($_POST['about_content']);
    $contact_mobile = $_POST['contact_mobile'];
    $contact_email = $_POST['contact_email'];
    $contact_address = $_POST['contact_address'];
    $hero_title = $_POST['hero_title'];
    $hero_subtitle = trim($_POST['hero_subtitle']);

    $about_image = $_FILES['about_image']['name'];
    $hero_image = $_FILES['hero_image']['name'];

    $target_dir = "../uploads/";

    if (!empty($about_image)) {
        $target_file = $target_dir . basename($about_image);
        move_uploaded_file($_FILES['about_image']['tmp_name'], $target_file);
    }

    if (!empty($hero_image)) {
        $target_file = $target_dir . basename($hero_image);
        move_uploaded_file($_FILES['hero_image']['tmp_name'], $target_file);
    }

    $query = "UPDATE settings SET
            site_name = '$site_name',
            about_title = '$about_title',
            about_content = '$about_content',
            about_image = '$about_image',
            contact_mobile = '$contact_mobile',
            contact_email = '$contact_email',
            contact_address = '$contact_address',
            hero_title = '$hero_title',
            hero_subtitle = '$hero_subtitle',
            hero_image = '$hero_image'
            WHERE id = 1";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Settings updated successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: settings.php');
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Settings</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="settings.php">Settings</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form action="settings.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" maxlength="255" value="<?= $settings['site_name'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="about_title" class="form-label">About Title</label>
                                <input type="text" class="form-control" id="about_title" name="about_title" maxlength="255" value="<?= $settings['about_title'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="about_content" class="form-label">About Content</label>
                                <textarea class="form-control" id="about_content" name="about_content" rows="3"><?= $settings['about_content'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="about_image" class="form-label">About Image</label>
                                <img width="200px" class="d-block py-3" src="../uploads/<?= $settings['about_image'] ?>" alt="Image">
                                <input type="file" class="form-control" id="about_image" name="about_image" maxlength="255">
                            </div>
                            <div class="mb-3">
                                <label for="contact_mobile" class="form-label">Contact Mobile</label>
                                <input type="text" class="form-control" id="contact_mobile" name="contact_mobile" maxlength="255" value="<?= $settings['contact_mobile'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" maxlength="255" value="<?= $settings['contact_email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contact_address" class="form-label">Contact Address</label>
                                <input type="text" class="form-control" id="contact_address" name="contact_address" maxlength="255" value="<?= $settings['contact_address'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="hero_title" class="form-label">Hero Title</label>
                                <input type="text" class="form-control" id="hero_title" name="hero_title" maxlength="255" value="<?= $settings['hero_title'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                                <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="3"><?= $settings['hero_subtitle'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="hero_image" class="form-label">Hero Image</label>
                                <img width="200px" class="d-block py-3" src="../uploads/<?= $settings['hero_image'] ?>" alt="Image">
                                <input type="file" class="form-control" id="hero_image" name="hero_image" maxlength="255">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">
                                Update
                                <span class="bi bi-check-all"></span>
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
