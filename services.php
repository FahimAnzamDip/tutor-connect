<?php $title = 'Services'; ?>

<?php include 'includes/header.php'; ?>

<?php
$query = "SELECT * FROM services";
$result = mysqli_query($connection, $query);
$services = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section section-padding text-center breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="breadcrumb-title display-4">Services</h2>
                    <nav>
                        <ol class="breadcrumb
                        justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="index.php">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Services Section Start -->
    <section class="services section-padding">
        <div class="container">
            <div class="row">
                <?php foreach ($services as $service) : ?>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <div class="service_icon text-warning" style="font-size: 70px;">
                                    <i class="<?= $service['icon'] ?>"></i>
                                </div>
                                <div class="service_content">
                                    <h3 class="mt-3"><?= $service['name'] ?></h3>
                                    <p class="mt-3"><?= $service['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

<?php include 'includes/footer.php'; ?>