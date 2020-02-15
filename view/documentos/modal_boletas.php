<!-- Modal Boletas -->
<div class="modal fade" id="boletaModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" v-if="boleta.id==''"><i class="fa fa-file"></i> Nueva Boleta</h5>
        <h5 class="modal-title" v-else><i class="fa fa-file"></i> Editar Boleta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
<!--        {{ $data.boleta }}-->
        <div class="d-inline-flex" style="width: 100%;">

          <!-- RUC -->
          <div class="" style="width: 26%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Dni o Ruc</small>
              <div class="input-group">
                <input type="text" class="form-control" v-model="boleta.ruc" placeholder="4216253">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </div>
          </div>


          <!-- Razon Social -->
          <div class="pl-2" style="width: 31%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Razon Social </small>
              <input type="text" class="form-control" v-model="boleta.razon" placeholder="">
            </div>
          </div>

          <!-- Direccion -->
          <div class="pl-2" style="width: 32%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Direccion </small>
              <input type="text" class="form-control" v-model="boleta.direccion" placeholder="">
            </div>
          </div>

          <!-- Opciones -->
          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Opcion </small>
              <div class="dropdown">
                <button class="btn btn-default btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu">
                  <form class="px-4 py-3" @submit.prevent="">

                    <!-- Serie -->
                    <div class="form-group">
                      <small class="form-text text-muted">Serie </small>
                      <select class="form-control" v-model="boleta.serie">
                        <option v-for="item in boleta_series">{{ item.serie }}</option>
                      </select>
                    </div>

                    <!-- Fecha Emision -->
                    <div class="form-group">
                      <small class="form-text text-muted">Fecha Emision </small>
                      <input type="date" class="form-control" v-model="boleta.fecha_emision">
                    </div>

                    <!-- Venta Interna -->
                    <div class="form-group">
                      <small class="form-text text-muted">Venta interna </small>
                      <select class="form-control" v-model="boleta.venta_interna">
                        <option value="1">Venta Interna</option>
                        <option value="2">Anticipo o Deduccion de Anticipo en venta interna</option>
                        <option value="3">Exportacion</option>
                      </select>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>

          <!-- Boton Agregar Fila -->
          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Agregar </small>
              <button class="btn btn-primary btn-block" @click="boletaAddLine">
                <i class="fa fa-plus"></i>
              </button>
            </div>
          </div>

        </div><!-- End Generales -->

        <!-- Items Titulos -->
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

        <!-- Items -->
        <div class="d-inline-flex mb-1" style="width: 100%;" v-for="(item, index) in boleta.items">

          <!-- Producto -->
          <div style="width: 37%; box-sizing: border-box;">
            <div class="pr-2 bg-light">
              <input type="search" class="form-control" :list="'boleta'+index" v-model="item.nombre" @input="boletaItemNombreChange(index,item,item.nombre)" autocomplete="off">
              <datalist :id="'boleta'+index" open="open">
                <option v-for="(result,index) in item.productos" :value="result.nombre">
              </datalist>
            </div>
          </div>

          <!-- Opciones -->
          <div style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">
              <div class="dropdown">
                <button class="btn btn-default btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu">
                  <form class="px-4 py-3" @submit.prevent="">

                    <!-- Tipo de IGV -->
                    <div class="form-group">
                      <small class="form-text text-muted">Tipo de IGV</small>
                      <select class="form-control" v-model="item.tipo_igv">
                        <option value="1">Gravada</option>
                        <option value="2">Exonerada</option>
                        <option value="3">Inafecto</option>
                      </select>
                    </div>

                    <!-- Descuento -->
                    <div class="form-group">
                      <small class="form-text text-muted">Descuento </small>
                      <input type="text" class="form-control" v-model="item.descuento" placeholder="0.00">
                    </div>

                    <!-- Igv Linea -->
                    <div class="form-group">
                      <small class="form-text text-muted">IGV Linea </small>
                      <input type="text" class="form-control" v-model="item.igv" placeholder="0.00">
                    </div>

                    <!-- Eliminar -->
                    <div class="form-group">
                      <small class="form-text text-muted">Eliminar</small>
                      <button class="btn btn-default"><i class="fa fa-trash"></i></button>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>

          <!-- Cantidad -->
          <div style="width: 12.5%; box-sizing: border-box;">
            <div class="pr-2 pl-2 bg-light">
              <input type="text" class="form-control text-right" v-model="item.cantidad" @input="facturaItemCantidadChange(index, item)" placeholder="0">
            </div>
          </div>

          <!-- Precio -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <input type="text" class="form-control text-right" v-model="item.precio_con_igv" @input="facturaItemPrecioChange(index, item)" placeholder="0.00">
            </div>
          </div>

          <!-- Subtotal -->
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <input type="text" class="form-control text-right" v-model="item.subtotal" placeholder="0.00" disabled>
            </div>
          </div>

          <!-- Total -->
          <div style="width: 15%; box-sizing: border-box;">
            <div class="bg-light">
              <input type="text" class="form-control text-right" v-model="item.total" placeholder="0.00" disabled>
            </div>
          </div>

        </div> <!-- End Item -->

      </div><!-- End Modal Body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
