<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title><?= lang('Auth.login') ?></title>
<?= $this->endSection() ?>

<?= $this->section('back'); ?>
<a href="<?= base_url(); ?>" class="btn btn-outline-primary m-3 position-absolute">
  <i class="ti ti-arrow-left"></i>
  Kembali
</a>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center p-5" style="background-color: #f8f9fa; min-height: 100vh;">
  <div class="card col-12 col-md-5 shadow-sm rounded-4 border-0">
    <div class="card-body">

      <!-- Logo dan Identitas Sekolah -->
      <div class="text-center mb-4">
        <img src="<?= base_url('assets/images/logo-smk.png') ?>" alt="Logo Sekolah" style="max-height: 80px;">
        <h5 class="fw-bold mt-2">SMK AS-SHOFA</h5>
        <p class="text-muted">Sistem Informasi Perpustakaan</p>
      </div>

      <h5 class="card-title mb-4 text-center"><?= lang('Auth.login') ?></h5>

      <!-- Flash Messages -->
      <?php if (session('error') !== null) : ?>
        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
      <?php elseif (session('errors') !== null) : ?>
        <div class="alert alert-danger" role="alert">
          <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
              <?= $error ?><br>
            <?php endforeach ?>
          <?php else : ?>
            <?= session('errors') ?>
          <?php endif ?>
        </div>
      <?php endif ?>

      <?php if (session('message') !== null) : ?>
        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
      <?php endif ?>

      <!-- Form Login -->
      <form action="<?= url_to('login') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
          <input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
        </div>

        <div class="mb-3">
          <input type="password" class="form-control" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required />
        </div>

        <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
          <div class="form-check mb-3">
            <label class="form-check-label">
              <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked<?php endif ?>>
              <?= lang('Auth.rememberMe') ?>
            </label>
          </div>
        <?php endif; ?>

        <div class="d-grid col-12 mx-auto mb-3">
          <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.login') ?></button>
        </div>

        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
          <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
        <?php endif ?>

        <!-- <?php if (setting('Auth.allowRegistration')) : ?>
          <p class="text-center"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
        <?php endif ?> -->
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
