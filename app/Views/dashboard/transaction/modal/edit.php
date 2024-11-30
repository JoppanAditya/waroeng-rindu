<!-- Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Transaction Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/transaction/update', ['class' => 'updateStatusForm']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="modal-body">
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <select class="form-select" id="status" name="status" aria-label="Status">
                            <option value="Awaiting Confirmation" <?= $status == 'Awaiting Confirmation' ? 'selected' : ''; ?>>Awaiting Confirmation</option>
                            <option value="Processed" <?= $status == 'Processed' ? 'selected' : ''; ?>>Processed</option>
                            <option value="Sent" <?= $status == 'Sent' ? 'selected' : ''; ?>>Sent</option>
                            <option value="Arrive at Destination" <?= $status == 'Arrive at Destination' ? 'selected' : ''; ?>>Arrive at Destination</option>
                            <option value="Cancelled" <?= $status == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="Finished" <?= $status == 'Finished' ? 'selected' : ''; ?>>Finished</option>
                        </select>
                        <label for="status">Status</label>
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
            $('.updateStatusForm').submit(function(e) {
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
                        $('.saveButton').html('Save Update');
                    },
                    success: function(response) {
                        if (response.error) {
                            Toast.fire({
                                icon: "error",
                                title: response.error
                            });
                        } else {
                            Toast.fire({
                                icon: "success",
                                title: response.success
                            });

                            $('#editModal').modal('hide');
                            transactionData();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });
        });
    </script>
