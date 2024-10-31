<!-- Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Category Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/category/update', ['class' => 'updateCategoryForm']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $category['id']; ?>">
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Category Name" value="<?= $category['name']; ?>">
                        <label for="name">Category Name</label>
                        <div class="invalid-feedback error-name"></div>
                    </div>
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
        $('.updateCategoryForm').submit(function(e) {
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
                        categoryData();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
