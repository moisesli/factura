<?php include "../layout/header.php" ?>
<?php include_once "../auth/_check_loggedin.php" ?>

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
      include_once './modal_enviar.php';
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
            <button class="btn btn-default" @click="facturaOpenModal('nuevo')"><i class="fa fa-plus"></i> Factura</button>
            <button class="btn btn-default" @click="boletaOpenModal('nuevo')"><i class="fa fa-plus"></i> Boleta</button>
            <button class="btn btn-default" @click="creditoOpenModal('nuevo')"><i class="fa fa-plus"></i> N. Credito</button>
            <button class="btn btn-default" @click="debitoOpenModal('nuevo')"><i class="fa fa-plus"></i> N. Debito</button>
          </div>
          <div class="col-sm-6 d-inline-flex text-right">
            <div style="width: 20%"></div>
            <div style="width: 25%; box-sizing: content-box;">
              <div class="mr-1">
<!--                <button class="btn btn-default btn-block"><i class="fa fa-upload"></i> E. Boletas</button>-->
              </div>
            </div>
            <div style="width: 25%; box-sizing: content-box;">
              <div class="mr-1">
                <button class="btn btn-default btn-block" @click="enviarDocumentos()"><i class="fa fa-upload"></i> Enviar</button>
              </div>
            </div>
            <div style="width: 30%; box-sizing: content-box;">
              <input type="text" class="form-control text-right" id="reservation">
            </div>
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
                    <th>Enviado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(doc,index) in docs">
                    <td>{{doc.tipo}}</td>
                    <td>{{doc.fecha_emision}}</td>
                    <td>{{doc.serie}}</td>
                    <td>{{doc.numero}}</td>
                    <td>{{doc.ruc}}</td>
                    <td>{{doc.razon}}</td>
                    <td>
                      <!-- Sunat -->
                      <span v-if="doc.sunat=='0'">Si</span>
                      <span v-else>No</span>
                    </td>
                    <td>{{doc.total_total}}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default">
                          <i class="fa fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split"
                                id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" data-reference="parent"> Opcion
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuReference">
                          <a class="dropdown-item" v-if="doc.tipo == 'factura'" @click="facturaOpenModal('editar',doc)" href="#">Editar Factura</a>
                          <a class="dropdown-item" v-if="doc.tipo == 'boleta'" @click="boletaOpenModal('editar',doc)" href="#">Editar Boleta</a>
                          <a class="dropdown-item" v-if="doc.tipo == 'credito'" @click="creditoOpenModal('editar',doc)" href="#">Editar Nota Credito</a>
                          <a class="dropdown-item" v-if="doc.tipo == 'debito'" @click="debitoOpenModal('editar',doc)" href="#">Editar Debito</a>
                          <a class="dropdown-item" @click="enviarDocumento(index)" href="#">Enviar Sunat</a>
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
