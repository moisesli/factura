<!-- Modal Facturas -->
<div class="modal fade" id="facturaModal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="factura.id ==''"><i class="fa fa-file"></i> Nueva Factura</h5>
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
            <div class="bg-light">
              <small class="form-text text-muted">Ruc </small>
              <div class="input-group">                
                <input type="text" class="form-control" placeholder="4216253">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </div>
          </div>

          <div class="pl-2" style="width: 31%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Razon Social </small>
              <input type="text" class="form-control" placeholder="">
            </div>
          </div>

          <div class="pl-2" style="width: 32%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Direccion </small>
              <input type="text" class="form-control" placeholder="">
            </div>
          </div>

          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Opcion </small>
              <button class="btn btn-default"><i class="fa fa-cog"></i></button>
            </div>
          </div>

          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Agregar </small>
              <button class="btn btn-default"><i class="fa fa-cog"></i></button>
            </div>
          </div>

        </div> <!-- End inline Flex -->

        <!-- ITEMS
        *************************************** -->
        <div class="d-inline-flex pt-2" style="width: 100%;">
          <!-- Producto -->
          <div class="pr-2" style="width: 39%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted">Productos </small>              
            </div>
          </div>
          <!-- Opciones -->
          <div class="pr-2" style="width: 6%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted">Opci</small>              
            </div>
          </div>
          <!-- Cantidad -->
          <div class="pr-2" style="width: 11%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted">Cantidad </small>              
            </div>
          </div>
          <!-- Precio -->
          <div class="pr-2" style="width: 15%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted">Precio </small>              
            </div>
          </div>
          <!-- Subtotal -->
          <div class="pr-2" style="width: 15%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted">Subtotal </small>              
            </div>
          </div>
          <!-- Total -->
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted">Total </small>              
            </div>
          </div>
        </div> 

        <div class="d-inline-flex" style="width: 100%;">
          <!-- Producto -->
          <div style="width: 37%; box-sizing: border-box;">
            <div class="pr-2 bg-light">                       
              <input type="text" class="form-control" placeholder="Producto">
            </div>
          </div>
          <!-- Opciones -->
          <div style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">              
              <button class="btn btn-default"><i class="fa fa-cog"></i></button>
            </div>
          </div>
          <!-- Cantidad -->
          <div style="width: 12.5%; box-sizing: border-box;">
            <div class="pr-2 pl-2 bg-light">                            
              <input type="text" class="form-control text-right" placeholder="0">
            </div>
          </div>
          <!-- Precio -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">              
              <input type="text" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
          <!-- Subtotal -->
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">              
              <input type="text" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
          <!-- Total -->
          <div style="width: 15%; box-sizing: border-box;">
            <div class="bg-light">              
              <input type="text" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
        </div>

        <!-- TOTALES 
        *****************************-->
        <!-- Gravada -->
        <div class="d-inline-flex pt-4  d-flex align-items-end align-items-center" style="width: 100%;">
          <div class="" style="width: 60%; box-sizing: content-box;">
          </div>
          <div class="text-right" style="width: 25%; box-sizing: content-box;">
            <div class="pr-2">
              Gravada
            </div>            
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-light">
              <input type="email" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
        </div>


        <!-- IGV -->
        <div class="d-inline-flex pt-2  d-flex align-items-end align-items-center" style="width: 100%;">
          <div class="" style="width: 60%; box-sizing: content-box;">
          </div>
          <div class="text-right" style="width: 25%; box-sizing: content-box;">
            <div class="pr-2">
              IGV
            </div>            
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-light">
              <input type="email" class="form-control text-right" placeholder="0.00">
            </div>
          </div>
        </div>

        <!-- TOTAL -->
        <div class="d-inline-flex pt-2  d-flex align-items-end align-items-center" style="width: 100%;">
          <div class="" style="width: 60%; box-sizing: content-box;">
          </div>
          <div class="text-right" style="width: 25%; box-sizing: content-box;">
            <div class="pr-2">
              TOTAL
            </div>            
          </div>
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="bg-light">
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
