<!-- Modal -->
<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Menu Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold ">Menu Name</div>
                    <div class="col-lg-9 col-md-8"><?= $menu['name']; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Slug</div>
                    <div class="col-lg-9 col-md-8"><?= $menu['slug']; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Description</div>
                    <div class="col-lg-9 col-md-8"><?= $menu['description']; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Category ID</div>
                    <div class="col-lg-9 col-md-8"><?= $menu['category_id']; ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 fw-bold">Price</div>
                    <div class="col-lg-9 col-md-8"><?= number_to_currency($menu['price'], 'IDR', 'id_ID'); ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-4 fw-bold">Image</div>
                    <div class="col-lg-9 col-md-8">
                        <div>
                            <img src="<?= base_url('assets/img/menu/' . $menu['image']) ?>" alt="Menu Image" class="img-thumbnail" style="max-height: 200px; width: auto;">
                            <div class="mt-2"><?= $menu['image']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
