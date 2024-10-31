<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add Address Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('address/add', ['class' => 'addAddressForm']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="user_id" value="<?= user_id() ?>">
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $user->fullname; ?>" placeholder="Recipient Name">
                    <label for="fullname">Recipient Name</label>
                    <div class="invalid-feedback error-fullname"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $user->mobile_number; ?>" placeholder="Phone Number">
                    <label for="phone">Phone Number</label>
                    <div class="invalid-feedback error-phone"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="label" name="label" placeholder="Address Label">
                    <label for="label">Address Label</label>
                    <div class="invalid-feedback error-label"></div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="province" aria-label="Province" name="province">
                        <option selected disabled>Select a Province</option>
                    </select>
                    <label for="province">Province</label>
                    <div class="invalid-feedback error-province"></div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="city" aria-label="City" name="city">
                        <option selected disabled>Select a City</option>
                    </select>
                    <label for="city">City</label>
                    <div class="invalid-feedback error-city"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code">
                    <label for="postal_code">Postal Code</label>
                    <div class="invalid-feedback error-postal_code"></div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Full Address" id="address" name="address" style="height: 100px"></textarea>
                    <label for="address">Full Address</label>
                    <div class="invalid-feedback error-address"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="notes" name="notes" placeholder="Notes for Courier">
                    <label for="notes">Notes for Courier</label>
                    <div class="invalid-feedback error-notes"></div>
                </div>

                <button type="submit" class="btn btn-primary saveButton">Add Address</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#addModal').on('shown.bs.modal', function() {
            $('#city').attr('disabled', 'disabled');
            $('#postal_code').attr('disabled', 'disabled');

            $.ajax({
                url: '<?= base_url("shipment/province") ?>',
                method: 'GET',
                success: function(response) {
                    if (response.data) {
                        $('#province').empty().append('<option selected disabled>Select a Province</option>');
                        response.data.forEach(function(province) {
                            $('#province').append(
                                $('<option>', {
                                    value: province.province_id,
                                    text: province.province
                                })
                            );
                        });
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.error || "Failed to load provinces"
                        });
                    }
                },
                error: function() {
                    console.error('Error fetching province data.');
                }
            });
        });

        $('#province').on('change', function() {
            const provinceId = $(this).val();
            $('#city').removeAttr('disabled', 'disabled');

            if (provinceId) {
                $.ajax({
                    url: '<?= base_url("shipment/city") ?>',
                    method: 'GET',
                    data: {
                        province_id: provinceId
                    },
                    success: function(response) {
                        if (response.data) {
                            $('#city').empty().append('<option selected disabled>Select a City</option>');
                            response.data.forEach(function(city) {
                                $('#city').append(
                                    $('<option>', {
                                        value: city.city_id,
                                        text: city.city_name,
                                        'data-postal-code': city.postal_code
                                    })
                                );
                            });
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.error || "Failed to load cities"
                            });
                        }
                    },
                    error: function() {
                        console.error('Error fetching city data.');
                    }
                });
            }
        });

        $('#city').on('change', function() {
            const postalCode = $('#city option:selected').data('postal-code');
            $('#postal_code').removeAttr('disabled', 'disabled');
            $('#postal_code').val(postalCode || '');
        });

        $('.addAddressForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.saveButton').attr('disabled', 'disabled');
                    $('.saveButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                complete: function() {
                    $('.saveButton').removeAttr('disabled', 'disabled');
                    $('.saveButton').html('Add Address');
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
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
