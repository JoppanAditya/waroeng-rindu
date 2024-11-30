<?php

use Carbon\Carbon;

if (!empty($users)): ?>
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Active</th>
                <th>Last Active</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <?php $role = $u->getGroups(); ?>
                    <td><?= $u->username; ?></td>
                    <td><?= $role[0]; ?></td>
                    <td><?= $u->active; ?></td>
                    <td><?= $u->last_active ? Carbon::parse($u->last_active)->diffForHumans(['options' => Carbon::NO_ZERO_DIFF]) : null; ?></td>
                    <td><?= Carbon::parse($u->created_at)->format('d M Y'); ?></td>
                    <td><?= Carbon::parse($u->updated_at)->format('d M Y'); ?></td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="detail('<?= $u->id ?>')"><i class="ri-eye-fill"></i></button>
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $u->id ?>')"><i class="bx bxs-edit"></i></button>
                        <button type="button" class="btn btn-danger" onclick="remove('<?= $u->id ?>')"><i class="bx bxs-trash"></i></button>
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
            url: '<?= base_url('admin/admin/detail') ?>',
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
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function edit(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/admin/editForm') ?>',
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
                    url: '<?= base_url('admin/admin/delete') ?>',
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
                            adminData();
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
