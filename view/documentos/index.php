<?php include "../layout/header.php" ?>

<div class="wrapper">

  <?php include '../layout/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="app">

    <?php
      // Import modal New All
      include_once './modal_facturas.php';
      include_once './modal_boletas.php';
      include_once './modal_notacredito.php';
      include_once './modal_notadebito.php';
    ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <!-- Titulo y Breadcrum -->
        <div class="row mb-3">
          <div class="col-sm-6">
            <h1>Documentos Electronicos {{nombre}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Documentos</li>
            </ol>
          </div>
        </div>
        <!-- Botones and DatePicker -->
        <div class="row d-flex justify-content-between">
          <div class="col-sm-6">
            <button class="btn btn-primary" @click="facturaOpenModal('nuevo')"><i class="fa fa-plus"></i> Factura</button>
            <button class="btn btn-secondary" @click="boletaOpenModal('nuevo')"><i class="fa fa-plus"></i> Boleta</button>
            <button class="btn btn-success" @click="creditoOpenModal('nuevo')"><i class="fa fa-plus"></i> N. Credito</button>
            <button class="btn btn-warning" @click="debitoOpenModal('nuevo')"><i class="fa fa-plus"></i> N. Debito</button>
          </div>
          <div class="w-30">
            <input type="text" class="form-control" id="reservation">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Documentos Electronicos 24 Enero 2019</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right"
                           placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">

                <table class="table table-hover">
                  <thead>
                  <tr>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Serie</th>
                    <th>Numero</th>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Total</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Factura</td>
                    <td>20-01-2019</td>
                    <td>F001</td>
                    <td>00004578</td>
                    <td><span class="tag tag-success">1042516253</span></td>
                    <td>Abraham Moises Linares Oscco</td>
                    <td>845.01</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default">
                          <i class="fa fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split"
                                id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" data-reference="parent">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuReference">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                      </div>
                    <td>
                  </tr>
                  <tr>
                    <td colspan="8" class="text-right">
                      T. Nota Debito 845.01 | T. Nota Credito 845.01 | T. Boletas 845.01 | T. Facturas 845.01
                    </td>
                  </tr>
                  </tbody>
                </table>
                <!-- / .Tabla Documentos -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<?php include '../layout/footer.php' ?>
<?php include_once './documentos_js.php' ?>
<script>
  Vue.config.productionTip = false;
  $(function () {
    $('#reservation').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
        format: 'DD/MM/YYYY'
      }
    });
  })
</script>
