<!-- Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Menu Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('admin/menu/update', ['class' => 'updateMenuForm']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $menu['id']; ?>">
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Menu Name" value="<?= $menu['name']; ?>">
                        <label for="name">Menu Name</label>
                        <div class="invalid-feedback error-name"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Slug" value="<?= $menu['slug']; ?>" readonly disabled>
                        <label for="slug">Slug</label>
                        <div class="invalid-feedback error-slug"></div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px;"><?= $menu['description']; ?></textarea>
                        <label for="description">Description</label>
                        <div class="invalid-feedback error-description"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <select class="form-select" id="category" name="category" aria-label="Category">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id']; ?>" <?= $menu['category_id'] == $c['id'] ? 'selected' : ''; ?>><?= $c['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="category">Category</label>
                        <div class="invalid-feedback error-category"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Product Price" value="<?= $menu['price']; ?>">
                        <label for="price">Price</label>
                        <div class="invalid-feedback error-price"></div>
                    </div>
                </div>
                <div class="col-md-12 d-flex mt-3 gap-3 align-items-start">
                    <div>
                        <?php if (!empty($menu['image'])): ?>
                            <img src="<?= base_url('assets/img/menu/' . $menu['image']) ?>" alt="Menu Image" class="img-fluid" style="max-width: 200px; height: auto;">
                            <div class="mt-2 text-center"><?= $menu['image']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input class="form-control" type="file" id="image" name="image">
                        <div class="invalid-feedback error-image"></div>
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
        $('.updateMenuForm').submit(function(e) {
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
