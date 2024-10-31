<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Update Address Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <input type="hidden" name="update_address_id" id="update_address_id">
                <input type="hidden" name="update_user_id" id="update_user_id" value="<?= user_id() ?>">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="update_user_name" name="name" placeholder="Recipient Name">
                        <label for="update_user_name">Recipient Name</label>
                        <small class="form-text text-danger" id="update-name-error"></small>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="update_user_phone" name="phone" placeholder="Phone Number">
                        <label for="update_user_phone">Phone Number</label>
                        <small class="form-text text-danger" id="update-phone-error"></small>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="update_address_label" name="label" placeholder="Address Label">
                        <label for="update_address_label">Address Label</label>
                        <small class="form-text text-danger" id="update-label-error"></small>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="update_address_city" name="city" placeholder="City & Province">
                        <label for="update_address_city">City & Province</label>
                        <small class="form-text text-danger" id="update-city-error"></small>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Full Address" id="update_address_full" name="address" style="height: 100px"></textarea>
                        <label for="update_address_full">Full Address</label>
                        <small class="form-text text-danger" id="update-address-error"></small>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="update_address_notes" name="notes" placeholder="Notes for Courier">
                        <label for="update_address_notes">Notes for Courier</label>
                        <small class="form-text text-danger" id="update-notes-error"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="save-changes" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
