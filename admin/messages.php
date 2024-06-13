<?php $title = 'Messages' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM messages WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Message deleted successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong';
    }

    header('location: messages.php');
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Messages</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Messages</li>
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
                                            <th class="align-middle text-center">Date</th>
                                            <th class="align-middle text-center">Name</th>
                                            <th class="align-middle text-center">Email</th>
                                            <th class="align-middle text-center">Subject</th>
                                            <th class="align-middle text-center">Message</th>
                                            <th class="align-middle text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = "SELECT * FROM messages";
                                        $messages = mysqli_query($connection, $query);
                                        ?>
                                        <?php if(mysqli_num_rows($messages) > 0): ?>
                                            <?php foreach ($messages as $key => $message): ?>
                                                <tr>
                                                    <td class="align-middle text-center"><?= $key+1 ?></td>
                                                    <td class="align-middle text-center"><?= $message['date'] ?></td>
                                                    <td class="align-middle text-center"><?= $message['name'] ?></td>
                                                    <td class="align-middle text-center"><?= $message['email'] ?></td>
                                                    <td class="align-middle text-center"><?= $message['subject'] ?></td>
                                                    <td class="align-middle text-center"><?= $message['message'] ?></td>
                                                    <td class="align-middle text-center">
                                                        <a href="messages.php?delete=<?= $message['id'] ?>" class="btn btn-danger btn-sm"
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
