<?= $this->extend('dashboard/layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="<?= base_url('assets/img/user/') . $user->image; ?>" alt="Profile Pricture" class="rounded-circle">
                        <h2><?= $user->fullname; ?></h2>
                        <h3><?= $user->role; ?></h3>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?= $user->fullname; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8"><?= $user->username; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Role</div>
                                    <div class="col-lg-9 col-md-8"><?= $user->role; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8"><?= $user->gender; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8"><?= $user->mobile_number; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= $user->email; ?></div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <?= form_open_multipart('admin/admin/update', ['class' => 'updateProfileForm']); ?>
                                <?= csrf_field(); ?>
                                <input type="hidden" name="id" value="<?= $user->id; ?>">
                                <input type="hidden" name="password" value="">

                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="<?= base_url('assets/img/user/') . $user->image; ?>" alt="Profile Picture">
                                        <div class="pt-2 d-flex gap-3">
                                            <div>
                                                <input class="form-control" type="file" id="image" name="image">
                                                <div class="invalid-feedback error-image"></div>
                                            </div>
                                            <button class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="fullname" type="text" class="form-control" id="fullname" value="<?= $user->fullname; ?>">
                                        <div class="invalid-feedback error-fullname"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="username" type="text" class="form-control" id="username" value="<?= $user->username; ?>">
                                        <div class="invalid-feedback error-username"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="role" class="col-md-4 col-lg-3 col-form-label">Role</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="role" type="text" class="form-control" id="role" value="<?= $user->role; ?>" readonly disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                    <div class="col-md-8 col-lg-9">
                                        <select class="form-select" id="gender" aria-label="Gender" name="gender">
                                            <option selected disabled>Select one</option>
                                            <option value="Male" <?= $user->gender == 'Male' ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= $user->gender == 'Female' ? 'selected' : '' ?>>Female</option>
                                        </select>
                                        <div class="invalid-feedback error-gender"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="mobile_number" class="col-md-4 col-lg-3 col-form-label">Mobile Number</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="mobile_number" type="text" class="form-control" id="mobile_number" value="<?= $user->mobile_number; ?>">
                                        <div class="invalid-feedback error-mobile_number"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email" value="<?= $user->email; ?>">
                                        <div class="invalid-feedback error-email"></div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary saveButton">Save Changes</button>
                                </div>
                                <?= form_close(); ?><!-- End Profile Edit Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <?= form_open('admin/admin/updatePassword', ['class' => 'changePasswordForm']); ?>
                                <?= csrf_field(); ?>
                                <input type="hidden" name="id" value="<?= $user->id; ?>">

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="password">
                                        <div class="invalid-feedback error-password"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newPassword" type="password" class="form-control" id="newPassword">
                                        <div class="invalid-feedback error-newPassword"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewPassword" type="password" class="form-control" id="renewPassword">
                                        <div class="invalid-feedback error-renewPassword"></div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                                <?= form_close(); ?><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.updateProfileForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.saveButton').attr('disabled', 'disabled');
                    $('.saveButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                success: function(response) {
                    $('.saveButton').removeAttr('disabled', 'disabled');
                    $('.saveButton').html('Save Changes');
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

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

        $('.changePasswordForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.changeButton').attr('disabled', 'disabled');
                    $('.changeButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                complete: function() {
                    $('.changeButton').removeAttr('disabled', 'disabled');
                    $('.changeButton').html('Change Password');
                },
                success: function(response) {
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

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
                        $('#password').val('');
                        $('#newPassword').val('');
                        $('#renewPassword').val('');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
