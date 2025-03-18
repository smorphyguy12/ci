<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration</title>
  <!-- jQuery -->
  <script src="<?= base_url('assets/') ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Toast -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>/dist/css/adminlte.min.css?v=3.2.0">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/toastr/toastr.min.css">

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="<?= base_url('assets/') ?>/index2.html" class="h1">Registration</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form id="registration" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Full name" name="fullname" id="fullname" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select name="gender" id="gender" class="form-control" id="gender" required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Retype password" name="retype_password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="<?= base_url('users/') ?>" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- Toastr -->
  <script src="<?= base_url('assets') ?>/plugins/toastr/toastr.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/') ?>/dist/js/adminlte.min.js?v=3.2.0"></script>

  <script>
    $(document).ready(function() {
      $('#registration').submit(function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
          url: '<?= base_url('users/register') ?>',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              $('#registration')[0].reset();
              toastr.success(response.message);

              setTimeout(function() {
                window.location.href = "<?= base_url('users/index') ?>";
              }, 3000);
            } else if (response.status == 2) {
              toastr.warning(response.message);
            } else {
              toastr.error(response.message);
            }
          },
          error: function(xhr, status, error) {
            alert('Error: ' + error);
            console.error('Error:', error, 'Response:', xhr.responseText);
          }
        });
      });
    });
  </script>
</body>

</html>