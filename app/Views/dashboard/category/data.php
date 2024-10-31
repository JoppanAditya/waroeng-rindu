<?php if (!empty($category)): ?>
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($category as $index => $c): ?>
                <tr>
                    <td><?= ++$index; ?></td>
                    <td><?= $c['name']; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="edit('<?= $c['id'] ?>')"><i class="bx bxs-edit"></i> Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="remove('<?= $c['id'] ?>')"><i class="bx bxs-trash"></i> Delete</button>
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
    function edit(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/category/editForm') ?>',
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
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
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
                    url: '<?= base_url('admin/category/delete') ?>',
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
                            categoryData();
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
    }
</script>
<script src="<?= base_url('assets/'); ?>js/dashboard-main.js"></script>
