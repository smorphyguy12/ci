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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Manage Users</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">User Management</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Fullname</td>
                                <td>Email</td>
                                <td>Gender</td>
                                <td>Date Created</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php while($this->model->getUsers) : ?>
                                <?php endwhile ;?>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php $this->load->view('partials/footer'); ?>
        <!-- ./Footer -->

        <!-- Control Sidebar -->
        <?php $this->load->view('partials/control-sidebar'); ?>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- Footer Scripts -->
    <?php $this->load->view('partials/footer-scripts'); ?>
</body>

</html>