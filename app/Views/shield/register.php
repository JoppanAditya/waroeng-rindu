<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5 pt-0">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5 text-center">Create an Account</h5>

            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Fullname -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control <?= isset(session('errors')['fullname']) ? 'is-invalid' : '' ?>" id="floatingFullnameInput" name="fullname" inputmode="text" autocomplete="fullname" placeholder="Fullname" value="<?= old('fullname') ?>">
                    <label for="floatingFullnameInput">Fullname</label>
                    <?php if (isset(session('errors')['fullname'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['fullname'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Username -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control <?= isset(session('errors')['username']) ? 'is-invalid' : '' ?>" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                    <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                    <?php if (isset(session('errors')['username'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['username'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Email -->
                <div class="form-floating mb-2">
                    <input type="email" class="form-control <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                    <?php if (isset(session('errors')['email'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['email'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Mobile Number -->
                <div class="form-floating mb-2">
                    <input type="tel" class="form-control <?= isset(session('errors')['mobile_number']) ? 'is-invalid' : '' ?>" id="floatingMobileNumberInput" name="mobile_number" autocomplete="tel" placeholder="Mobile Number (without hyphen)" value="<?= old('mobile_number') ?>">
                    <label for="floatingMobileNumberInput">Mobile Number (without hyphen)</label>
                    <?php if (isset(session('errors')['mobile_number'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['mobile_number'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Birth Date -->
                <div class="form-floating mb-2">
                    <input type="date" class="form-control <?= isset(session('errors')['date_of_birth']) ? 'is-invalid' : '' ?>" id="floatingBirthInput" name="date_of_birth" inputmode="text" autocomplete="date_of_birth" placeholder="Birth Date" value="<?= old('date_of_birth') ?>">
                    <label for="floatingBirthInput">Birth Date</label>
                    <?php if (isset(session('errors')['date_of_birth'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['date_of_birth'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Gender -->
                <div class="form-floating mb-2">
                    <select class="form-select <?= isset(session('errors')['gender']) ? 'is-invalid' : '' ?>" id="floatingGenderSelect" aria-label="Gender" name="gender">
                        <option selected disabled>Select one</option>
                        <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <label for="floatingGenderSelect">Gender</label>
                    <?php if (isset(session('errors')['gender'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['gender'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Password -->
                <div class="form-floating mb-2">
                    <input type="password" class="form-control <?= isset(session('errors')['password']) ? 'is-invalid' : '' ?>" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>">
                    <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                    <?php if (isset(session('errors')['password'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['password'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Password (Again) -->
                <div class="form-floating mb-5">
                    <input type="password" class="form-control <?= isset(session('errors')['password_confirm']) ? 'is-invalid' : '' ?>" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>">
                    <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                    <?php if (isset(session('errors')['password_confirm'])) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['password_confirm'] ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                </div>

                <p class="text-center"><?= lang('Auth.haveAccount') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
