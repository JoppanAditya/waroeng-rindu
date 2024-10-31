<?php

use Carbon\Carbon; ?>

<!-- Modal -->
<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">User Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold ">User ID</div>
                    <div class="col-lg-9 col-md-8"><?= $user->id; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold ">Fullname</div>
                    <div class="col-lg-9 col-md-8"><?= $user->fullname; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Username</div>
                    <div class="col-lg-9 col-md-8"><?= $user->username; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Email</div>
                    <div class="col-lg-9 col-md-8"><?= $user->email; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Mobile Number</div>
                    <div class="col-lg-9 col-md-8"><?= $user->mobile_number; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Date of Birth</div>
                    <div class="col-lg-9 col-md-8"><?= Carbon::parse($user->date_of_birth)->format('l, d F Y'); ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Gender</div>
                    <div class="col-lg-9 col-md-8"><?= $user->gender; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Image</div>
                    <div class="col-lg-9 col-md-8">
                        <div class="d-flex gap-3">
                            <img src="<?= base_url('assets/img/user/' . $user->image) ?>" alt="User Image" class="img-thumbnail" style="max-height: 120px; width: auto;">
                            <div class="mt-2"><?= $user->image; ?></div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Active</div>
                    <div class="col-lg-9 col-md-8"><?= $user->active; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Status</div>
                    <div class="col-lg-9 col-md-8"><?= $user->status; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Status Message</div>
                    <div class="col-lg-9 col-md-8"><?= $user->status_message; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Last Active</div>
                    <div class="col-lg-9 col-md-8"><?= $user->last_active ? Carbon::parse($user->last_active)->format('d F Y, H:i') : null; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Created at</div>
                    <div class="col-lg-9 col-md-8"><?= Carbon::parse($user->created_at)->format('d F Y, H:i'); ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Updated at</div>
                    <div class="col-lg-9 col-md-8"><?= Carbon::parse($user->updated_at)->format('d F Y, H:i'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
