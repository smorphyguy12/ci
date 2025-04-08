<?php
if (!$this->session->id) {
    redirect(base_url());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>

    <!-- Header CSS -->
    <?php $this->load->view('partials/head-css'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Pre Loader -->
    <?php $this->load->view('partials/pre-loader'); ?>

    <!-- Top NavBar -->
    <?php $this->load->view('partials/topnav'); ?>

    <!-- Side NavBar -->
    <?php $this->load->view('partials/sidenav'); ?>

    <!-- Content -->
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Manage Users</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">User Management</li>
                            </ol>
                        </div>
                    </div>

                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addUserModal">Add User</button>
                </div>
            </div>

            <div class="container-fluid">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($row as $data) : ?>
                            <tr>
                                <td><?= htmlspecialchars($data->fullname) ?></td>
                                <td><?= htmlspecialchars($data->email) ?></td>
                                <td><?= htmlspecialchars($data->gender) ?></td>
                                <td><?= htmlspecialchars($data->date_created) ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-edit" data-id="<?= $data->id ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $data->id ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php $this->load->view('partials/footer'); ?>
        <?php $this->load->view('partials/control-sidebar'); ?>
    </div>

    <?php $this->load->view('partials/footer-scripts'); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn-edit').click(function () {
                const id = $(this).data('id');
                $.ajax({
                    url: "<?= base_url('users/fetchUser') ?>",
                    type: "POST",
                    dataType: "json",
                    data: { id },
                    success: function (response) {
                        if (response.status === 1) {
                            const data = response.data;
                            $('#hide-id').val(data.id);
                            $('#edt-fullname').val(data.fullname);
                            $('#edt-email').val(data.email);
                            $('#edt-gender').val(data.gender);
                            $('.edit-modal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Error: ' + error);
                        console.error('Error:', error, 'Response:', xhr.responseText);
                    }
                });
            });

            $('#edit-form').submit(function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "<?= base_url('users/editUsers') ?>",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    success: function (response) {
                        if (response.status === 1) {
                            toastr.success(response.message);
                            $('.edit-modal').modal('hide');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Error: ' + error);
                        console.error('Error:', error, 'Response:', xhr.responseText);
                    }
                });
            });

            $('#add-user-form').submit(function(e) {
              e.preventDefault();

              const formData = $(this).serialize();

              $.ajax({
                url: "<?= base_url('users/addUser') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                  if (response.status === 1) {
                    toastr.success(response.message);
                    $('#addUserModal').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                  } else {
                    toastr.error(response.message);
                  }
                },
                error: function(xhr, status, error) {
                  console.error('Error:', error, 'Response:', xhr.responseText);
                }
              });
            });


            $('.btn-delete').click(function () {
                const id = $(this).data('id');
                
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: "<?= base_url('users/deleteUsers') ?>",
                        type: "POST",
                        dataType: "json",
                        data: { id: id },
                        success: function (response) {
                            if (response.status === 1) {
                                toastr.success(response.message);
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Error: ' + error);
                            console.error('Error:', error, 'Response:', xhr.responseText);
                        }
                    });
                }
            });

        });
    </script>
</body>

</html>


<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="add-user-form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="add-fullname">Fullname</label>
            <input type="text" class="form-control" id="add-fullname" name="fullname" required>
          </div>
          <div class="form-group">
            <label for="add-email">Email</label>
            <input type="email" class="form-control" id="add-email" name="email" required>
          </div>
          <div class="form-group">
            <label for="add-gender">Gender</label>
            <select class="form-control" id="add-gender" name="gender" required>
              <option value="" disabled selected>Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label for="add-password">Password</label>
            <input type="password" class="form-control" id="add-password" name="password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade edit-modal" id="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="edit-form">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hide-id">
                    <div class="form-group mb-3">
                        <label for="fullname">Fullname</label>
                        <input type="text" class="form-control" id="edt-fullname" name="fullname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="edt-email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="edt-gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
