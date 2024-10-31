<!-- Modal -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Menu Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('admin/menu/add', ['class' => 'addMenuForm']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Menu Name">
                        <label for="name">Menu Name</label>
                        <div class="invalid-feedback error-name"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
                        <label for="slug">Slug</label>
                        <div class="invalid-feedback error-slug"></div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px;"></textarea>
                        <label for="description">Description</label>
                        <div class="invalid-feedback error-description"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <select class="form-select" id="category" name="category" aria-label="Category">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="category">Category</label>
                        <div class="invalid-feedback error-category"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Product Price">
                        <label for="price">Price</label>
                        <div class="invalid-feedback error-price"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <input class="form-control" type="file" id="image" name="image">
                    <div class="invalid-feedback error-image"></div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary saveButton">Add Menu</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.addMenuForm').submit(function(e) {
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
                    $('.saveButton').html('Add Menu');
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
