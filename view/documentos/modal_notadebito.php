<!-- Modal Debito -->
<div class="modal fade" id="debitoModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Nueva Nota Debito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Datos Generales -->
        <div class="d-inline-flex" style="width: 100%;">

          <!-- Buscar Documento 20.5% -->
          <div class="" style="width: 20.5%; box-sizing: content-box;">
            <div class="mr-2">
              <small class="form-text text-muted">Buscar Doc</small>
              <div class="input-group">
                <input type="text" class="form-control text-right" @keyup.enter="debitoImportDoc(debito.numero)" v-model="debito.numero" placeholder="0000789">
                <div class="input-group-append">
                  <span class="input-group-text" @click="debitoImportDoc(debito.numero)"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </div>
          </div>

          <!-- RUC 20% -->
          <div class="" style="width: 16%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Dni o Ruc</small>
              <input type="text" class="form-control text-right" v-model="debito.ruc" :disabled="credito.ruc == ''">
            </div>
          </div>

          <!-- Razon Social 29% -->
          <div class="pl-2" style="width: 29%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Razon Social </small>
              <input type="text" class="form-control" v-model="debito.razon" :disabled="credito.razon == ''">
            </div>
          </div>

          <!-- Direccion 25% -->
          <div class="pl-2" style="width: 25%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Direccion </small>
              <input type="text" class="form-control" v-model="debito.direccion" :disabled="credito.direccion == ''">
            </div>
          </div>

          <!-- Opciones 5.5% -->
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
                      <select class="form-control" v-model="debito.serie">
                        <option v-for="item in debito_series">{{ item.serie }}</option>
                      </select>
                    </div>

                    <!-- Fecha Emision -->
                    <div class="form-group">
                      <small class="form-text text-muted">Fecha Emision </small>
                      <input type="date" class="form-control" v-model="debito.fecha_emision">
                    </div>

                    <!-- Venta Interna -->
                    <div class="form-group">
                      <small class="form-text text-muted">Venta interna </small>
                      <select class="form-control" v-model="debito.venta_interna">
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

          <!-- Add Item 5.5% -->
          <div class="pl-2" style="width: 5.5%; box-sizing: content-box;">
            <div class="bg-light">
              <small class="form-text text-muted">Agregar </small>
              <button class="btn btn-primary btn-block" @click="debitoAddLine">
                <i class="fa fa-plus"></i>
              </button>
            </div>
          </div>

        </div><!-- End Datos Generales -->

        <!-- Items Titulos -->
        <div class="d-inline-flex pt-2" style="width: 100%;">

          <!-- Producto -->
          <div style="width: 37%; box-sizing: content-box;">
            <div class="pr-2">
              <small class="form-text text-muted">Productos </small>
            </div>
          </div>

          <!-- Opciones -->
          <div style="width: 5.5%; box-sizing: content-box;">
            <div class="">
              <small class="form-text text-muted">Opci</small>
            </div>
          </div>

          <!-- Cantidad -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <small class="form-text text-muted">Cantidad </small>
            </div>
          </div>
          <!-- Precio -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <small class="form-text text-muted">Precio </small>
            </div>
          </div>
          <!-- Subtotal -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <small class="form-text text-muted">Subtotal </small>
            </div>
          </div>
          <!-- Total -->
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div>
              <small class="form-text text-muted text-right pr-2">Total </small>
            </div>
          </div>

        </div><!-- End Items Titulos -->


        <!-- Items -->
        <div class="d-inline-flex mb-1" style="width: 100%;" v-for="(item, index) in debito.items">

          <!-- Producto 37% -->
          <div style="width: 37%; box-sizing: border-box;">
            <div class="pr-2 bg-light">
              <input type="search" class="form-control" :list="'debito'+index" v-model="item.nombre" @input="debitoItemNombreChange(index,item,item.nombre)" autocomplete="off">
              <datalist :id="'debito'+index" open="open">
                <option v-for="(result,index) in item.productos" :value="result.nombre">
              </datalist>
            </div>
          </div>

          <!-- Opciones 5.5% -->
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

          <!-- Cantidad 12.5% -->
          <div style="width: 12.5%; box-sizing: border-box;">
            <div class="pr-2 pl-2 bg-light">
              <input type="text" class="form-control text-right" v-model="item.cantidad" @input="debitoItemCantidadChange(index, item)" placeholder="0">
            </div>
          </div>

          <!-- Precio 15% -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <input type="text" class="form-control text-right" v-model="item.precio_con_igv" @input="debitoItemPrecioChange(index, item)" placeholder="0.00">
            </div>
          </div>

          <!-- Subtotal 15% -->
          <div class="" style="width: 15%; box-sizing: content-box;">
            <div class="pr-2">
              <input type="text" class="form-control text-right" v-model="item.subtotal" placeholder="0.00" disabled>
            </div>
          </div>

          <!-- Total 15% -->
          <div style="width: 15%; box-sizing: border-box;">
            <div class="bg-light">
              <input type="text" class="form-control text-right" v-model="item.total" placeholder="0.00" disabled>
            </div>
          </div>

        </div> <!-- End Items -->


        <!-- Totales -->
        <div class="d-inline-flex mb-1" style="width: 100%;">

          <!-- Espacio-->
          <div style="width: 55%; box-sizing: content-box;"></div>

          <!-- Gravadas -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="mr-2">
              <small class="form-text text-muted">Gravadas </small>
              <input type="email" class="form-control text-right" v-model="debito.total_gravadas" placeholder="0.00" disabled>
            </div>
          </div>

          <!-- IGV -->
          <div style="width: 15%; box-sizing: content-box;">
            <div class="mr-2">
              <small class="form-text text-muted">IGV </small>
              <input type="email" class="form-control text-right" v-model="debito.total_igv" placeholder="0.00" disabled>
            </div>
          </div>

          <!-- Total -->
          <div style="width: 15%; box-sizing: content-box;">
            <small class="form-text text-muted text-right pr-2"><strong>Total</strong> </small>
            <input type="email" class="form-control text-right" v-model="debito.total_total" placeholder="0.00" disabled>
          </div>
        </div><!-- End Totales -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" v-if="debito.id ==''" @click="debitoSave"><i class="fa fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-primary" v-else @click="debitoSave"><i class="fa fa-edit"></i> Editar</button>
      </div>
    </div>
  </div>
</div>
