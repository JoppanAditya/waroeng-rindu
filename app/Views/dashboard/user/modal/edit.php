<!-- Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit User Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('admin/user/update', ['class' => 'updateUserForm']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $user->id; ?>">
            <div class="modal-body">
                <!-- Fullname -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control <?= isset(session('errors')['fullname']) ? 'is-invalid' : '' ?>" id="floatingFullnameInput" name="fullname" inputmode="text" autocomplete="fullname" placeholder="Fullname" value="<?= $user->fullname ?>">
                    <label for="floatingFullnameInput">Fullname</label>
                    <?php if (isset(session('errors')['fullname'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['fullname'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Username -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control <?= isset(session('errors')['username']) ? 'is-invalid' : '' ?>" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="Username" value="<?= $user->username ?>">
                    <label for="floatingUsernameInput">Username</label>
                    <?php if (isset(session('errors')['username'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['username'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Email -->
                <div class="form-floating mb-2">
                    <input type="email" class="form-control <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="Email" value="<?= $user->email ?>">
                    <label for="floatingEmailInput">Email</label>
                    <?php if (isset(session('errors')['email'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['email'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Mobile Number -->
                <div class="form-floating mb-2">
                    <input type="tel" class="form-control <?= isset(session('errors')['mobile_number']) ? 'is-invalid' : '' ?>" id="floatingMobileNumberInput" name="mobile_number" autocomplete="tel" placeholder="Mobile Number (without hyphen)" value="<?= $user->mobile_number ?>">
                    <label for="floatingMobileNumberInput">Mobile Number (without hyphen)</label>
                    <?php if (isset(session('errors')['mobile_number'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['mobile_number'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Birth Date -->
                <div class="form-floating mb-2">
                    <input type="date" class="form-control <?= isset(session('errors')['date_of_birth']) ? 'is-invalid' : '' ?>" id="floatingBirthInput" name="date_of_birth" inputmode="text" autocomplete="date_of_birth" placeholder="Birth Date" value="<?= $user->date_of_birth ?>">
                    <label for="floatingBirthInput">Birth Date</label>
                    <?php if (isset(session('errors')['date_of_birth'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['date_of_birth'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Gender -->
                <div class="form-floating mb-2">
                    <select class="form-select <?= isset(session('errors')['gender']) ? 'is-invalid' : '' ?>" id="floatingGenderSelect" aria-label="Gender" name="gender">
                        <option selected disabled>Select one</option>
                        <option value="Male" <?= $user->gender == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user->gender == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <label for="floatingGenderSelect">Gender</label>
                    <?php if (isset(session('errors')['gender'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['gender'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Password -->
                <div class="form-floating mb-2">
                    <input type="password" class="form-control <?= isset(session('errors')['password']) ? 'is-invalid' : '' ?>" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="Password">
                    <label for="floatingPasswordInput">Password</label>
                    <?php if (isset(session('errors')['password'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['password'] ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary saveButton">Save Update</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.updateUserForm').submit(function(e) {
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
                    $('.saveButton').html('Save Update');
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

                        $('#editModal').modal('hide');
                        menuData();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
