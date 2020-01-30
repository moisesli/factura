<!-- Modal Facturas -->
<div class="modal fade" id="facturaModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- Titulo -->
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
                      <select class="form-control">
                        <option value="1">F001</option>
                        <option value="2">F002</option>
                        <option value="3">F003</option>
                      </select>
                    </div>

                    <!-- Fecha Emision -->
                    <div class="form-group">
                      <small class="form-text text-muted">Fecha Emision </small>
                      <input type="date" class="form-control" placeholder="Password">
                    </div>

                    <!-- Venta Interna -->
                    <div class="form-group">
                      <small class="form-text text-muted">Venta interna </small>
                      <select class="form-control">
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
              <button class="btn btn-primary btn-block" @click="facturaAddLine">
                <i class="fa fa-plus"></i>
              </button>
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

        <div class="d-inline-flex mb-1" style="width: 100%;" v-for="(item, index) in factura.items">
          <!-- Producto -->
          <div style="width: 37%; box-sizing: border-box;">
            <div class="pr-2 bg-light">

              <!-- <select id="supplier_id" class="form-control select2bs4" v-model="item.nombre" v-select='supplier_id' @input="facturaItemNombreChange(index,item,item.nombre)">
                <option value="arr">arr</option>
                <option value="niklesh">Niklesh</option>
                <option value="sachin">Sachin</option>
                <option v-for="(result,index) in item.productos">{{result.nombre}}</option>
              </select> -->
              <input type="search" class="form-control" :list="'nombre'+index" v-model="item.nombre" @input="facturaItemNombreChange(index,item,item.nombre)" onmousedown="value = '';" autocomplete="off">
              <datalist :id="'nombre'+index" open="open">
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
              <input type="text" class="form-control text-right" v-model="item.cantidad" @input="facturaItemCantidadChange(item)" placeholder="0">
            </div>
          </div>
          <!-- Precio -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <input type="text" class="form-control text-right" v-model="item.precio_sin_igv" @input="facturaItemPrecioChange(item)" placeholder="0.00">
            </div>
          </div>
          <!-- Subtotal -->
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <input type="text" class="form-control text-right" v-model="item.subtotal" placeholder="0.00">
            </div>
          </div>
          <!-- Total -->
          <div style="width: 15%; box-sizing: border-box;">
            <div class="bg-light">
              <input type="text" class="form-control text-right" v-model="item.total" @input="facturaItemTotalChange(item)" placeholder="0.00">
            </div>
          </div>
        </div> <!-- End Line -->

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
        <button type="button" class="btn btn-primary" v-if="factura.id ==''"><i class="fa fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-primary" v-else><i class="fa fa-edit"></i> Editar</button>
      </div>
    </div>
  </div>
</div>