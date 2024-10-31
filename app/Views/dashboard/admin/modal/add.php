<!-- Modal -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Admin Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('admin/admin/add', ['class' => 'addAdminForm']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <!-- Fullname -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="fullname" name="fullname" inputmode="text" autocomplete="fullname" placeholder="Fullname" value="<?= old('fullname'); ?>">
                    <label for="fullname">Fullname</label>
                    <div class="invalid-feedback error-fullname"></div>
                </div>

                <!-- Username -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="username" name="username" inputmode="text" autocomplete="username" placeholder="Username" value="<?= old('username'); ?>">
                    <label for="username">Username</label>
                    <div class="invalid-feedback error-username"></div>
                </div>

                <!-- Email -->
                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="email" name="email" inputmode="email" autocomplete="email" placeholder="Email" value="<?= old('email'); ?>">
                    <label for="email">Email</label>
                    <div class="invalid-feedback error-email"></div>
                </div>

                <!-- Mobile Number -->
                <div class="form-floating mb-2">
                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number" autocomplete="tel" placeholder="Mobile Number (without hyphen)" value="<?= old('mobile_number'); ?>">
                    <label for="mobile_number">Mobile Number (without hyphen)</label>
                    <div class="invalid-feedback error-mobile_number"></div>
                </div>

                <!-- Gender -->
                <div class="form-floating mb-2">
                    <select class="form-select" id="gender" aria-label="Gender" name="gender">
                        <option selected disabled>Select one</option>
                        <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <label for="gender">Gender</label>
                    <div class="invalid-feedback error-gender"></div>
                </div>

                <!-- Password -->
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" id="password" name="password" inputmode="text" autocomplete="new-password" placeholder="Password">
                    <label for="password">Password</label>
                    <div class="invalid-feedback error-password"></div>
                </div>

                <!-- Password -->
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="Password (Again)">
                    <label for="password">Password (Again)</label>
                    <div class="invalid-feedback error-password_confirm"></div>
                </div>

                <div class="col-md-12 mt-3">
                    <input class="form-control" type="file" id="image" name="image">
                    <div class="invalid-feedback error-image"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary saveButton">Add Admin</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.addAdminForm').submit(function(e) {
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
                complete: function() {
                    $('.saveButton').removeAttr('disabled', 'disabled');
                    $('.saveButton').html('Add Admin');
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

                        $('#addModal').modal('hide');
                        adminData();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
