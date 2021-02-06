    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Bisnis TIK</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Daftar Peserta Bisnis TIK</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="myTable"> 
                                    <thead>
                                        <tr>
                                            <th>Nama TIM</th>
                                            <th>Deskripsi TIM</th>
                                            <th>Instansi</th>
                                            <th>Nama Ketua</th>
                                            <th>Email</th>
                                            <th>No. HP</th>
                                            <th>Berkas</th>
                                            <th>Tanggal Daftar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($bisnis as $row){?>
                                        <tr>
                                            <td><?php echo $row['nama_tim']; ?></td>
                                            <td><?php echo $row['desc_tim']; ?></td>
                                            <td><?php echo $row['instansi']; ?></td>
                                            <td><?php echo $row['nama_ketua']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['hp']; ?></td>
                                            <td><a href="<?= base_url("assets/berkas/bisnis/".$row['filename']); ?>">Download</a></td>
                                            <td><?php echo $row['tanggal_daftar']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->