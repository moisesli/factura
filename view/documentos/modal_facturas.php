<!-- Modal Facturas -->
<div class="modal fade" id="facturaModal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="factura.id ==''">Nueva Factura</h5>
        <h5 class="modal-title" v-else>Editar Factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Datos Generales-->
        <div class="d-inline-flex" style="width: 100%;">

          <!-- RUC -->
          <div class="" style="width: 26%; box-sizing: content-box;">
            <div class="bg-blue">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="RUC">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </div>
          </div>

          <div class="pl-2" style="width: 31%; box-sizing: content-box;">
            <div class="bg-cyan">
              <input type="text" class="form-control" placeholder="Razon">
            </div>
          </div>

          <div class="pl-2" style="width: 32%; box-sizing: content-box;">
            <div class="bg-blue">
              <input type="text" class="form-control" placeholder="Direccion">
            </div>
          </div>

          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-blue">
              <button class="btn btn-default"><i class="fa fa-cog"></i></button>
            </div>
          </div>

          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-blue">
              <button class="btn btn-default"><i class="fa fa-cog"></i></button>
            </div>
          </div>

        </div> <!-- End inline Flex -->

        <!-- Items -->
        <div class="d-inline-flex pt-4" style="width: 100%;">
          <div class="pr-2" style="width: 39%; box-sizing: content-box;">
            <div class="bg-cyan">
              <input type="text" class="form-control" placeholder="Producto">
            </div>
          </div>

          <div class="" style="width: 5%; box-sizing: content-box;">
            <div class="bg-blue">
              a
            </div>
          </div>

          <div class="" style="width: 11%; box-sizing: content-box;">
            <div class="bg-blue">
              a
            </div>
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-cyan">
              a
            </div>
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-blue">
              a
            </div>
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-cyan">
              a
            </div>
          </div>
        </div>

        <div class="pt-4">
          <input type="text" class="form-control mr-2" style="width: 35%; float: left;" placeholder="Producto">
          <button class="btn btn-default mr-2" style="float: left;"><i class="fa fa-cog"></i></button>
          <input type="text" class="form-control mr-2 text-right" style="width: 13%; float: left;" placeholder="0.00">
          <input type="text" class="form-control mr-2 text-right" style="width: 13%; float: left;" placeholder="0.00">
          <input type="text" class="form-control mr-2 text-right" style="width: 13%; float: left;" placeholder="0.00">
          <input type="text" class="form-control text-right" style="width: 15%;" placeholder="0.00">
        </div>


        <!-- Gravada -->
        <div class="d-inline-flex pt-4  d-flex align-items-end align-items-center" style="width: 100%;">
          <div class="" style="width: 60%; box-sizing: content-box;">
          </div>
          <div class="pr-2 text-right" style="width: 25%; box-sizing: content-box;">
            Gravada
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-blue">
              <input type="email" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
        </div>

        <!-- IGV -->
        <div class="d-inline-flex pt-2  d-flex align-items-end align-items-center" style="width: 100%;">
          <div class="" style="width: 60%; box-sizing: content-box;">
          </div>
          <div class="pr-2 text-right" style="width: 25%; box-sizing: content-box;">
            IGV
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-blue">
              <input type="email" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
        </div>

        <!-- TOTAL -->
        <div class="d-inline-flex pt-2  d-flex align-items-end align-items-center" style="width: 100%;">
          <div class="" style="width: 60%; box-sizing: content-box;">
          </div>
          <div class="pr-2 text-right" style="width: 25%; box-sizing: content-box;">
            TOTAL
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-blue">
              <input type="email" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>
