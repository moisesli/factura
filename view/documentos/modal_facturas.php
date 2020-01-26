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

        <div>
          <div class="input-group pr-2" style="width: 26%; float: left;">
            <input type="text" class="form-control" placeholder="RUC">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
          </div>
          <input type="text" class="form-control mr-2" style="width: 30%; float: left;" placeholder="Razon">
          <input type="text" class="form-control mr-2" style="width: 30%; float: left" placeholder="Direccion">
          <button class="btn btn-default mr-2" style="float: left;"><i class="fa fa-cog"></i></button>
          <button class="btn btn-default"><i class="fa fa-plus"></i></button>
        </div>

        <div class="pt-4 clearfix">
          <input type="text" class="form-control mr-2" style="width: 35%; float: left;" placeholder="Producto">
          <button class="btn btn-default mr-2" style="float: left;"><i class="fa fa-cog"></i></button>
          <input type="text" class="form-control mr-2 text-right" style="width: 13%; float: left;" placeholder="0.00">
          <input type="text" class="form-control mr-2 text-right" style="width: 13%; float: left;" placeholder="0.00">
          <input type="text" class="form-control mr-2 text-right" style="width: 13%; float: left;" placeholder="0.00">
          <input type="text" class="form-control text-right" style="width: 15%;" placeholder="0.00">
        </div>


        <div class="form-group row pt-3 pb-0 mb-2 text-right">
          <label for="inputEmail3" class="col-sm-10 col-form-label">Gravada</label>
          <div class="col-sm-2">
            <input type="email" class="form-control" id="inputEmail3">
          </div>
        </div>

        <div class="form-group row pt-0 pb-0 mt-0 mb-2 text-right">
          <label for="inputEmail3" class="col-sm-10">IGV</label>
          <div class="col-sm-2">
            <input type="email" class="form-control" id="inputEmail3">
          </div>
        </div>

        <div class="form-group row pt-0 mt-0 text-right">
          <label for="inputEmail3" class="col-sm-10 col-form-label">Total</label>
          <div class="col-sm-2">
            <input type="email" class="form-control" id="inputEmail3">
          </div>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
