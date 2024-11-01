<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Update Address Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('address/update', ['class' => 'updateAddressForm']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="address_id" value="<?= $address['id'] ?>">
            <input type="hidden" name="user_id" value="<?= user_id() ?>">
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $address['name'] ?>" placeholder="Recipient Name">
                    <label for="fullname">Recipient Name</label>
                    <div class="invalid-feedback error-fullname"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $address['phone'] ?>" placeholder="Phone Number">
                    <label for="phone">Phone Number</label>
                    <div class="invalid-feedback error-phone"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="label" name="label" value="<?= $address['label'] ?>" placeholder="Address Label">
                    <label for="label">Address Label</label>
                    <div class="invalid-feedback error-label"></div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="province" name="province">
                        <option selected disabled>Select a Province</option>
                        <?php foreach ($provinces as $province): ?>
                            <option value="<?= esc($province['province_id']) ?>"
                                <?= $province['province_id'] == $address['province'] ? 'selected' : '' ?>>
                                <?= esc($province['province']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="province">Province</label>
                    <div class="invalid-feedback error-province"></div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="city" name="city">
                        <option selected disabled>Select a City</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= esc($city['city_id']) ?>"
                                <?= $city['city_id'] == $address['city'] ? 'selected' : '' ?>>
                                <?= esc($city['city_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="city">City</label>
                    <div class="invalid-feedback error-city"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?= $address['postal_code'] ?>" placeholder="Postal Code">
                    <label for="postal_code">Postal Code</label>
                    <div class="invalid-feedback error-postal_code"></div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Full Address" id="address" name="address" style="height: 100px"><?= $address['full_address'] ?></textarea>
                    <label for="address">Full Address</label>
                    <div class="invalid-feedback error-address"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="notes" name="notes" value="<?= $address['notes'] ?>" placeholder="Notes for Courier">
                    <label for="notes">Notes for Courier</label>
                    <div class="invalid-feedback error-notes"></div>
                </div>

                <button type="submit" class="btn btn-primary saveButton">Save Changes</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#province').on('change', function() {
            const provinceId = $(this).val();
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
            $('#postal_code').val(postalCode || '');
        });

        $('.updateAddressForm').submit(function(e) {
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
                    $('.saveButton').html('Save Changes');
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
                        $('#updateModal').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
