<?php $title = 'Contact Us'; ?>

<?php include 'includes/header.php'; ?>

    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section section-padding text-center breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="breadcrumb-title display-4">Contact Us</h2>
                    <nav>
                        <ol class="breadcrumb
                        justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="index.php">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Start -->
    <section class="contact-section section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="section-title">Get in Touch</h2>
                    <p class="section-text mb-5">We are here to help you. If you have any questions or need any help,
                        feel
                        free to contact us.</p>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" rows="5" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message <i class="bi bi-envelope ms-1"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-5">
                    <h2 class="section-title">Contact Information</h2>
                    <p class="section-text mb-5">Feel free to contact us for any queries or help.</p>
                    <div class="contact-info">
                        <div class="contact-info-item d-flex align-items-center">
                            <i class="bi bi-geo-alt  text-info me-3" style="font-size: 30px;"></i>
                            <div>
                                <h4>Address</h4>
                                <p>123, Main Street, New York, NY 10001</p>
                            </div>
                        </div>
                        <div class="contact-info-item d-flex align-items-center">
                            <i class="bi bi-envelope text-info me-3" style="font-size: 30px;"></i>
                            <div>
                                <h4>Email</h4>
                                <p>
                                    <a href="mailto:tutorconnect@mail.com">
                                        tutorconnect@mail.comm
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="contact-info-item d-flex align-items-center">
                            <i class="bi bi-telephone text-info me-3" style="font-size: 30px;"></i>
                            <div>
                                <h4>Phone</h4>
                                <p>+1 234 567 890</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Map Section Start -->
    <div>
        <iframe style="vertical-align: middle;" width="100%" height="400" frameborder="0" scrolling="no"
                marginheight="0" marginwidth="0" id="gmap_canvas"
                src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=New%20York%20New%20York+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        <a href='https://dissertationschreibenlassen.com/'>dissertationschreibenlassen.com</a>
        <script type='text/javascript'
                src='https://embedmaps.com/google-maps-authorization/script.js?id=2904f24519549cc58ecd2fd5106999567f9dbf5c'></script>
    </div>
    <!-- Map Section End -->

<?php include 'includes/footer.php'; ?>