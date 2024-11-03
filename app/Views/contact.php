<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Contact</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Contact</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Get in touch</h1>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="h-100 rounded">
                        <iframe class="rounded w-100"
                            style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d963.4167772745694!2d106.83533150894206!3d-6.185833635000765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4373412bbf1%3A0x7f73a28f635d6dc4!2sGedung%20Tedja%20Buana!5e0!3m2!1sid!2sid!4v1730641607170!5m2!1sid!2sid"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-7">
                    <?= form_open('contact/send', ['class' => 'contactForm']); ?>
                    <?= csrf_field(); ?>
                    <input type="text" id="name" name="name" class="w-100 form-control border-0 py-3 <?= isset(session('errors')['name']) ? 'is-invalid' : '' ?>" placeholder="Your Name" value="<?= old('name') ?>">
                    <div class="invalid-feedback">
                        <?= isset(session('errors')['name']) ? session('errors')['name'] : '' ?>
                    </div>

                    <input type="email" id="email" name="email" class="w-100 form-control border-0 py-3 mt-4 <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" placeholder="Enter Your Email" value="<?= old('email') ?>">
                    <div class="invalid-feedback">
                        <?= isset(session('errors')['email']) ? session('errors')['email'] : '' ?>
                    </div>

                    <textarea id="message" name="message" class="w-100 form-control border-0 mt-4 <?= isset(session('errors')['message']) ? 'is-invalid' : '' ?>" rows="5" cols="10" placeholder="Your Message"><?= old('message') ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset(session('errors')['message']) ? session('errors')['message'] : '' ?>
                    </div>

                    <button class="w-100 btn form-control border-secondary py-3 mt-4 bg-white text-primary submitButton" type="submit">Submit</button>
                    <?= form_close(); ?>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Address</h4>
                            <p class="mb-2">Menteng, Jakarta. Indonesia.</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Mail Us</h4>
                            <p class="mb-2">info@waroengrindu.swmenteng.com</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Telephone</h4>
                            <p class="mb-2">(+021) 3456 7890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<!-- <script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    $(document).ready(function() {
        $('.contactForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.submitButton').attr('disabled', 'disabled');
                    $('.submitButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                complete: function() {
                    $('.submitButton').removeAttr('disabled', 'disabled');
                    $('.submitButton').html('Submit');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.errors) {
                            for (let field in response.errors) {
                                if (response.errors.hasOwnProperty(field)) {
                                    const inputElement = $(`#${field}`);
                                    const errorElement = inputElement.siblings(`.invalid-feedback`);

                                    if (inputElement.length) {
                                        inputElement.addClass('is-invalid');
                                    }

                                    if (errorElement.length) {
                                        errorElement.text(response.errors[field]);
                                    }
                                }
                            }
                        }
                        Toast.fire({
                            icon: "error",
                            title: response.message
                        });
                    } else {
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script> -->
<?= $this->endSection(); ?>
