<?php foreach ($address as $a) : ?>
    <div class="card mt-3 <?= $a['is_selected'] == 1 ? 'border-primary' . '"' . 'style="background-color: rgba(52, 104, 192, .1);"' : ''; ?>">
        <div class="card-body text-start row" style="font-size: 14px;">
            <div class="col-sm-9 col-md-10">
                <h5 class="fs-6">
                    <?= $a['label']; ?>
                    <span class="badge bg-secondary fw-normal ms-2" <?= $a['is_default'] == 1 ? '' : 'style="display:none;"'; ?>>Primary</span>
                </h5>
                <h5 class="mb-1 fs-6"><?= $a['name']; ?></h5>
                <p class="mb-1"><?= $a['phone']; ?></p>
                <p class="mb-1"><?= $a['full_address'] . ', ' . $a['city_name'] . ', ' . $a['province_name']; ?> <span><?= $a['notes'] ? '(' . $a['notes'] . ')' : ''; ?></span></p>
            </div>
            <div class="col-sm-3 col-md-2 d-flex justify-content-center align-items-center gap-2" style="color: #3468c0;">
                <?php if ($a['is_selected'] == 1) : ?>
                    <i class="bi bi-check-circle-fill fs-3 ms-auto ms-sm-0 text-primary"></i>
                <?php else : ?>
                    <button type="button" class="btn btn-primary w-100 selectButton py-2 mt-2" data-address-id="<?= $a['id'] ?>" data-user-id="<?= $a['user_id'] ?>">Select</button>
                <?php endif; ?>
            </div>
            <div class="d-inline-flex mt-2 align-items-end">
                <button type="button" class="btn btn-link text-decoration-none border-0 p-0 pe-3 d-none d-sm-block updateButton" data-address-id="<?= $a['id'] ?>" style="font-size: 14px;">Edit Address</button>

                <button type="button" class="btn btn-light w-100 py-2 text-decoration-none d-sm-none updateButton" data-address-id="<?= $a['id'] ?>" style="font-size: 14px;">Edit Address</button>

                <?php if ($a['is_selected'] == 0 && $a['is_default'] == 0) : ?>
                    <button class="btn btn-light ms-2 d-sm-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#option-<?= $a['id'] ?>" aria-controls="option-<?= $a['id'] ?>"><i class="fas fa-ellipsis-v"></i></button>
                    <!-- Offcanvas -->
                    <div class="offcanvas offcanvas-bottom rounded-top-4 d-sm-none" tabindex="-1" id="option-<?= $a['id'] ?>" aria-labelledby="optionLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="optionLabel">Another Options</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body d-flex flex-column gap-3 align-items-start small">
                            <button type="button" class="btn btn-link text-decoration-none border-0 p-0 primaryButton d-sm-none" data-address-id="<?= $a['id'] ?>" data-user-id="<?= $a['user_id'] ?>" style="font-size: 14px;">Make it Primary Address & Select</button>
                            <button type="button" onclick="remove(<?= $a['id'] ?>)" class="btn btn-link text-decoration-none border-0 p-0 d-sm-none" style="font-size: 14px;">Delete</button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-link text-decoration-none border-0 border-start p-0 px-3 primaryButton d-none d-sm-block" data-address-id="<?= $a['id'] ?>" data-user-id="<?= $a['user_id'] ?>" style="font-size: 14px;">Make it Primary Address & Select</button>
                    <button type="button" onclick="remove(<?= $a['id'] ?>)" class="btn btn-link text-decoration-none border-0 border-start p-0 ps-3 d-none d-sm-block" style="font-size: 14px;">Delete</button>
                <?php elseif ($a['is_selected'] == 1 && $a['is_default'] == 0) : ?>
                    <button class="btn btn-light ms-2 d-sm-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#option-<?= $a['id'] ?>" aria-controls="option-<?= $a['id'] ?>"><i class="fas fa-ellipsis-v"></i></button>
                    <!-- Offcanvas -->
                    <div class="offcanvas offcanvas-bottom rounded-top-4 d-sm-none" tabindex="-1" id="option-<?= $a['id'] ?>" aria-labelledby="optionLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="optionLabel">Another Options</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body small">
                            <button type="button" class="btn btn-link text-decoration-none border-0 p-0 primaryButton d-sm-none" data-address-id="<?= $a['id'] ?>" data-user-id="<?= $a['user_id'] ?>" style="font-size: 14px;">Make it Primary Address</button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-link text-decoration-none border-0 border-start p-0 px-3 primaryButton d-none d-sm-block" data-address-id="<?= $a['id'] ?>" data-user-id="<?= $a['user_id'] ?>" style="font-size: 14px;">Make it Primary Address</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function remove(id) {
        Swal.mixin({
            customClass: {
                confirmButton: "btn btn-outline-primary",
                cancelButton: "btn btn-danger me-2"
            },
            buttonsStyling: false
        }).fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('address/delete') ?>',
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Toast.fire({
                                icon: "success",
                                title: response.message
                            });
                            addressData();
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.message
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    };

    $(document).ready(function() {
        $('.updateButton').click(function(e) {
            e.preventDefault();
            const addressId = $(this).data('address-id');

            $.ajax({
                url: '<?= base_url('address/editForm') ?>',
                method: 'POST',
                data: {
                    addressId: addressId
                },
                dataType: 'json',
                success: function(response) {
                    $('#addressModal').modal('hide');
                    $('.viewModal').html(response.data).show();
                    $('#updateModal').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $('.selectButton').click(function(e) {
            e.preventDefault();
            const id = $(this).data('address-id');
            const userId = $(this).data('user-id');

            if (typeof id === 'undefined' || typeof userId === 'undefined') {
                console.error('ID or user ID is undefined.');
                return;
            }

            $.ajax({
                url: '<?= base_url('address/updateSelected') ?>',
                method: 'POST',
                data: {
                    id: id,
                    user_id: userId
                },
                success: (response) => {
                    if (response.success) {
                        location.reload();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message
                        });
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error updating selection:', error);
                }
            });
        });

        $('.primaryButton').click(function(e) {
            e.preventDefault();
            const id = $(this).data('address-id');
            const userId = $(this).data('user-id');

            if (typeof id === 'undefined' || typeof userId === 'undefined') {
                console.error('ID or user ID is undefined.');
                return;
            }

            $.ajax({
                url: '<?= base_url('address/updatePrimary') ?>',
                method: 'POST',
                data: {
                    id: id,
                    user_id: userId
                },
                success: (response) => {
                    if (response.success) {
                        addressData();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message
                        });
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error updating selection:', error);
                }
            });
        });
    });
</script>
