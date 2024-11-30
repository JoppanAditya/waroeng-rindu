<?php if (!empty($menus)): ?>
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th>
                    <b>Name</b>
                </th>
                <th>Slug</th>
                <th>Category</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $m): ?>
                <tr>
                    <td><?= $m['name']; ?></td>
                    <td><?= $m['slug']; ?></td>
                    <td><?= $m['category_name']; ?></td>
                    <td><?= number_to_currency($m['price'], 'IDR', 'id_ID'); ?></td>
                    <td>
                        <div style="width: 110px; height: 110px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <img src="<?= base_url('assets/img/menu/') . $m['image']; ?>"
                                class="img-thumbnail"
                                alt="<?= $m['name']; ?> Image"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="detail('<?= $m['id'] ?>')"><i class="ri-eye-fill"></i></button>
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $m['id'] ?>')"><i class="bx bxs-edit"></i></button>
                        <button type="button" class="btn btn-danger" onclick="remove('<?= $m['id'] ?>')"><i class="bx bxs-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
<?php else: ?>
    <h3 class="text-center my-5">Belum ada data</h3>
<?php endif; ?>

<div class="viewModal"></div>


<script>
    function detail(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/menu/detail') ?>',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#detailModal').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function edit(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/menu/editForm') ?>',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#editModal').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

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
                    url: '<?= base_url('admin/menu/delete') ?>',
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
                            menuData();
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.message
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
</script>
<script src="<?= base_url('assets/'); ?>js/dashboard-main.js"></script>
