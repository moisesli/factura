<!-- Modal Facturas -->
<div class="modal fade" id="enviarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- Titulo -->
        <h5 class="modal-title"><i class="fa fa-file"></i> Enviando Sunat Fecha : {{enviar.fecha_emision}}</h5>
      </div>
      <div class="modal-body">
        <div class="text-center pb-3">
          <i class="fas fa-spinner fa-spin fa-3x" v-if="enviar.enviando=='ok'"></i>
          <i class="fas fa-check fa-3x" v-if="enviar.enviando=='si'"></i>
        </div>
        <div class="text-center">
          {{enviar.descripcion}}<br>
          <span v-if="enviar.enviando=='ok'">Enviando...</span>
          <span v-if="enviar.enviando=='si'">Enviado Correctamente!!.</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Enviar</button>

      </div>
    </div>
  </div>
</div>
