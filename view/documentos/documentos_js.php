<script>
  var app = new Vue({
    el: '#app',
    data: {
      nombre: 'moises',
      enviar: {
        enviando: '',
        tipo: '',
        serie: '',
        numero: '',
        fecha_emision: ''
      },
      enviando: 'ok',
      docs: [],
      productosList: [],
      factura_series: [],
      factura_default: null,
      credito_series: [],
      debito_series: [],
      boleta_series: [],
      boleta_default: null,
      boleta: {
        id: '',
        tipo: 'boleta',
        ruc: '',
        razon: '',
        direccion: '',
        serie: '',
        fecha_emision: '',
        venta_interna: '',
        total_gravadas: '',
        total_igv: '',
        total_total: '',
        items: [{
          productos: [],
          nombre: '',
          producto_id: '',
          unidad: '',
          cantidad: null,
          precio_con_igv: null,
          precio_sin_igv: null,
          igv: null,
          tipo_igv: '0',
          descuento: null,
          subtotal: null,
          total: null
        }]
      },
      factura: {
        id: '',
        tipo: 'factura',
        ruc: '',
        razon: '',
        direccion: '',
        serie: '',
        fecha_emision: '',
        venta_interna: '',
        total_gravadas: null,
        total_igv: null,
        total_total: null,
        items: [{
          id: '',
          productos: [],
          nombre: '',
          producto_id: '',
          unidad: '',
          cantidad: null,
          precio_con_igv: null,
          precio_sin_igv: null,
          igv: null,
          tipo_igv: '0',
          descuento: null,
          subtotal: null,
          total: null
        }]
      },
      credito: {
        id: '',
        numero: '',
        tipo: 'credito',
        ruc: '',
        razon: '',
        direccion: '',
        serie: '',
        fecha_emision: '',
        venta_interna: '',
        referencia_numero: '',
        referencia_serie: '',
        total_gravadas: '',
        total_igv: '',
        total_total: '',
        items: [{
          productos: [],
          nombre: '',
          producto_id: '',
          unidad: '',
          cantidad: null,
          precio_con_igv: null,
          precio_sin_igv: null,
          igv: null,
          tipo_igv: '0',
          descuento: null,
          subtotal: null,
          total: null
        }]
      },
      debito: {
        id: '',
        tipo: 'debito',
        numero: '',
        ruc: '',
        razon: '',
        direccion: '',
        serie: '',
        fecha_emision: '',
        venta_interna: '',
        referencia_numero: '',
        referencia_serie: '',
        total_gravadas: '',
        total_igv: '',
        total_total: '',
        items: [{
          id: '',
          productos: [],
          nombre: '',
          producto_id: '',
          unidad: '',
          cantidad: null,
          precio_con_igv: null,
          precio_sin_igv: null,
          igv: null,
          tipo_igv: '0',
          descuento: null,
          subtotal: null,
          total: null
        }]
      }
    },
    methods: {
      enviarDocumento: function(i){
        this.enviar.enviando = 'ok';
        this.enviar.tipo = this.docs[i].tipo;
        this.enviar.serie = this.docs[i].serie;
        this.enviar.numero = this.docs[i].numero;
        this.enviar.fecha_emision = this.docs[i].fecha_emision;
        $('#enviarModal').modal('show');
        axios.post('./_enviar.php?f='+this.enviar.tipo).then(res => {
          if (res.data == 'ok'){
            // $('#enviarModal').modal('hide');
            this.enviar.enviando = 'si';
          }else{

          }

        })

      },
      debitoImportDoc: function(numero){
        axios.post('./_documentos.php?f=debito_import_doc', { numero: numero }).then(res => {
          this.debito.id = '';
          this.debito.ruc = res.data.ruc;
          this.debito.razon = res.data.razon;
          this.debito.direccion = res.data.direccion;
          this.debito.referencia_numero = res.data.numero;
          this.debito.referencia_serie = res.data.serie;
          // 3 : Credito Facturas
          // 6 : Credito Boletas
          if (res.data.tipo == 'factura') {
            // console.log(res.data.tipo)
            this.debitoSeries(3);
          } else if (res.data.tipo == 'boleta') {
            this.debitoSeries(6);
          }
          this.debito.fecha_emision = '<?php echo date('Y-m-d') ?>';
          this.debito.venta_interna = '1';
          // this.debito.items = res.data.items;
          this.debito.total_gravadas = res.data.total_gravadas;
          this.debito.total_igv = res.data.total_igv;
          this.debito.total_total = res.data.total_total;
        })
      },
      creditoSave: function(){
        axios.post('./_documentos.php?f=credito_save', {credito: this.credito}).then(res => {
          // console.log(res.data)
          if (res.data == 'ok') {
            Swal.fire({
              title: 'Factura Guardada!',
              text: 'correctamente!!!',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              $('#creditoModal').modal('hide')
              this.facturaList();
            });
          } else {
            Swal.fire({
              title: 'Error No se Guardo!',
              text: 'Corregir!!!',
              icon: 'error',
              confirmButtonText: 'Continuar'
            }).then((result) => {
              $('#creditoModal').modal('hide')
            });
          }
        })
      },
      creditoImportDoc: function (numero) {
        axios.post('./_documentos.php?f=credito_import_doc', {numero: numero}).then(res => {
          this.credito.id = '';
          this.credito.ruc = res.data.ruc;
          this.credito.razon = res.data.razon;
          this.credito.direccion = res.data.direccion;
          this.credito.referencia_numero = res.data.numero;
          this.credito.referencia_serie = res.data.serie;
          // 2 : Credito Facturas
          // 5 : Credito Boletas
          if (res.data.tipo == 'factura') {
            this.creditoSeries(2);
          } else if (res.data.tipo == 'boleta') {
            this.creditoSeries(5);
          }
          this.credito.fecha_emision = '<?php echo date('Y-m-d') ?>';
          this.credito.venta_interna = '1';
          this.credito.items = res.data.items;
          this.credito.total_gravadas = res.data.total_gravadas;
          this.credito.total_igv = res.data.total_igv;
          this.credito.total_total = res.data.total_total;

          // console.log(res.data)
        })
      },
      facturaSeries: function () {
        axios.post('./_documentos.php?f=get_series', {tipo: 1}).then(res => {
          this.factura_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.factura_default = item.serie;
            }
          })
        })
      },
      creditoSeries: function (tipo) {
        axios.post('./_documentos.php?f=get_series', {tipo: tipo}).then(res => {
          this.credito_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.credito.serie = item.serie;
            }
          })
        })
      },
      debitoSeries: function (tipo) {
        axios.post('./_documentos.php?f=get_series', {tipo: tipo}).then(res => {
          this.debito_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.debito.serie = item.serie;
            }
          })
        })
      },
      facturaCreditoSeries: function () {
        axios.post('./_documentos.php?f=get_series', {tipo: 2}).then(res => {
          this.factura_credito_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.factura_credito_default = item.serie;
            }
          })
          // console.log(res.data)
        })
      },
      facturaDebitoSeries: function () {
        axios.post('./_documentos.php?f=get_series', {tipo: 3}).then(res => {
          this.factura_debito_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.factura_debito_default = item.serie;
            }
          })
          // console.log(res.data)
        })
      },
      boletaSeries: function () {
        axios.post('./_documentos.php?f=get_series', {tipo: 4}).then(res => {
          this.boleta_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.boleta_default = item.serie;
            }
          })
          // console.log(this.boleta_default)
        })
      },
      debitoItemNombreChange: function (index, item, text) {
        // console.log(text);
        axios.post('./_documentos.php?f=searchproductos', {text: text}).then(res => {
          // console.log(this.factura.items[index].productos)
          if (res.data[0].lista == 'unoIgual') {
            this.debito.items[index].productos = null;
            this.debito.items[index].nombre = res.data[0].nombre;
            this.debito.items[index].producto_id = res.data[0].id;
            this.debito.items[index].cantidad = 1;
            this.debito.items[index].precio_sin_igv = res.data[0].precio_sin_igv;
            this.debito.items[index].precio_con_igv = res.data[0].precio_con_igv;
            this.debito.items[index].igv = res.data[0].igv;
            this.debito.items[index].descuento = res.data[0].descuento;
            this.debito.items[index].subtotal = res.data[0].subtotal;
            this.debito.items[index].total = res.data[0].total;
            this.debitoItemsSumTotal();
          } else if (res.data[0].lista == 'ceroNinguno') {
            this.debito.items[index].productos = null;
            if (this.debito.items[index].cantidad == null){
              this.debito.items[index].cantidad = null;
              this.debito.items[index].precio_con_igv = null;
              this.debito.items[index].subtotal = null;
              this.debito.items[index].total = null;
            }
          } else {
            this.debito.items[index].productos = res.data;
            if (this.debito.items[index].cantidad == null){
              this.debito.items[index].cantidad = null;
              this.debito.items[index].precio_con_igv = null;
              this.debito.items[index].subtotal = null;
              this.debito.items[index].total = null;
            }

          }
        });

      },
      boletaItemNombreChange: function (index, item, text) {
        // console.log(text);
        axios.post('./_documentos.php?f=searchproductos', {text: text}).then(res => {
          // console.log(this.factura.items[index].productos)
          if (res.data[0].lista == 'unoIgual') {
            this.boleta.items[index].productos = null;
            this.boleta.items[index].nombre = res.data[0].nombre;
            this.boleta.items[index].producto_id = res.data[0].id;
            this.boleta.items[index].cantidad = 1;
            this.boleta.items[index].precio_sin_igv = res.data[0].precio_sin_igv;
            this.boleta.items[index].precio_con_igv = res.data[0].precio_con_igv;
            this.boleta.items[index].igv = res.data[0].igv;
            this.boleta.items[index].descuento = res.data[0].descuento;
            this.boleta.items[index].subtotal = res.data[0].subtotal;
            this.boleta.items[index].total = res.data[0].total;
            this.boletaItemsSumTotal();
          } else if (res.data[0].lista == 'ceroNinguno') {
            this.boleta.items[index].productos = null;
            this.boleta.items[index].cantidad = null;
            this.boleta.items[index].precio_con_igv = null;
            this.boleta.items[index].subtotal = null;
            this.boleta.items[index].total = null;
          } else {
            this.boleta.items[index].productos = res.data;
            this.boleta.items[index].cantidad = null;
            this.boleta.items[index].precio_con_igv = null;
            this.boleta.items[index].subtotal = null;
            this.boleta.items[index].total = null;
            // console.log(this.boleta.items[index].productos)
          }
        });

      },
      boletaCreditoSeries: function () {
        axios.post('./_documentos.php?f=get_series', {tipo: 5}).then(res => {
          this.boleta_credito_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.boleta_credito_default = item.serie;
            }
          })
          // console.log(res.data)
        })
      },
      boletaDebitoSeries: function () {
        axios.post('./_documentos.php?f=get_series', {tipo: 6}).then(res => {
          this.boleta_debito_series = res.data;
          res.data.forEach(item => {
            if (item.defecto == '1') {
              this.boleta_debito_default = item.serie;
            }
          })
          // console.log(res.data)
        })
      },
      facturaList: function () {
        axios.post('./_documentos.php?f=factura_list').then(res => {
          this.docs = res.data;
          // console.log(res.data)
        })
      },
      debitoSave: function () {
        axios.post('./_documentos.php?f=debito_save', {debito: this.debito}).then(res => {
          if (res.data == 'ok') {
            Swal.fire({
              title: 'Factura Guardada!',
              text: 'correctamente!!!',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              $('#debitoModal').modal('hide')
              this.facturaList();
            });
          } else {
            Swal.fire({
              title: 'Error No se Guardo!',
              text: 'Corregir!!!',
              icon: 'error',
              confirmButtonText: 'Continuar'
            }).then((result) => {
              $('#debitoModal').modal('hide')
            });
          }
        })
      },
      boletaSave: function () {
        console.log(this.boleta)
        // $('#boletaModal').modal('hide')

        axios.post('./_documentos.php?f=boleta_save', {boleta: this.boleta}).then(res => {
          // console.log(res.data)
          if (res.data == 'ok') {
            Swal.fire({
              title: 'Factura Guardada!',
              text: 'correctamente!!!',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              $('#boletaModal').modal('hide')
              this.facturaList();
            });
          } else {
            Swal.fire({
              title: 'Error No se Guardo!',
              text: 'Corregir!!!',
              icon: 'error',
              confirmButtonText: 'Continuar'
            }).then((result) => {
              $('#boletaModal').modal('hide')
            });
          }
        })
      },
      facturaSave: function () {
        // console.log(this.factura)

        axios.post('./_documentos.php?f=factura_save_new', {factura: this.factura}).then(res => {
          // console.log(res.data)
          if (res.data == 'ok') {
            Swal.fire({
              title: 'Factura Guardada!',
              text: 'correctamente!!!',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              $('#facturaModal').modal('hide')
              this.facturaList();
            });
          } else {
            Swal.fire({
              title: 'Error No se Guardo!',
              text: 'Corregir!!!',
              icon: 'error',
              confirmButtonText: 'Continuar'
            }).then((result) => {
              $('#facturaModal').modal('hide')
            });
          }
        })

      },
      debitoItemsSumTotal: function () {

        // Sumatorias
        let tempSumGravadas = 0.00;
        let tempSumIgv = 0.00;
        let tempSumTotal = 0.00;

        this.debito.items.forEach(item => {
          // console.log(typeof tempSumGravadas + typeof item.subtotal);
          tempSumGravadas = parseFloat(tempSumGravadas) + parseFloat(item.subtotal);
          tempSumIgv = parseFloat(tempSumIgv) + parseFloat(item.igv);
          tempSumTotal = parseFloat(tempSumTotal) + parseFloat(item.total);
          tempSumGravadas = tempSumGravadas.toFixed(2);
          tempSumIgv = tempSumIgv.toFixed(2);
          tempSumTotal = tempSumTotal.toFixed(2);
        });
        this.debito.total_gravadas = tempSumGravadas;
        this.debito.total_igv = tempSumIgv;
        this.debito.total_total = tempSumTotal;

      },
      boletaItemsSumTotal: function () {

        // Sumatorias
        let tempSumGravadas = 0.00;
        let tempSumIgv = 0.00;
        let tempSumTotal = 0.00;

        this.boleta.items.forEach(item => {
          // console.log(typeof tempSumGravadas + typeof item.subtotal);
          tempSumGravadas = parseFloat(tempSumGravadas) + parseFloat(item.subtotal);
          tempSumIgv = parseFloat(tempSumIgv) + parseFloat(item.igv);
          tempSumTotal = parseFloat(tempSumTotal) + parseFloat(item.total);
          tempSumGravadas = tempSumGravadas.toFixed(2);
          tempSumIgv = tempSumIgv.toFixed(2);
          tempSumTotal = tempSumTotal.toFixed(2);
        });
        this.boleta.total_gravadas = tempSumGravadas;
        this.boleta.total_igv = tempSumIgv;
        this.boleta.total_total = tempSumTotal;

      },
      facturaItemsSumTotal: function () {

        // Sumatorias
        let tempSumGravadas = 0.00;
        let tempSumIgv = 0.00;
        let tempSumTotal = 0.00;

        this.factura.items.forEach(item => {
          // console.log(typeof tempSumGravadas + typeof item.subtotal);
          tempSumGravadas = parseFloat(tempSumGravadas) + parseFloat(item.subtotal);
          tempSumIgv = parseFloat(tempSumIgv) + parseFloat(item.igv);
          tempSumTotal = parseFloat(tempSumTotal) + parseFloat(item.total);
          tempSumGravadas = tempSumGravadas.toFixed(2);
          tempSumIgv = tempSumIgv.toFixed(2);
          tempSumTotal = tempSumTotal.toFixed(2);
        });
        this.factura.total_gravadas = tempSumGravadas;
        this.factura.total_igv = tempSumIgv;
        this.factura.total_total = tempSumTotal;

      },
      facturaItemNombreChange: function (index, item, text) {
        // console.log(text);

        axios.post('./_documentos.php?f=searchproductos', {
          text: text
        }).then(res => {
          // console.log(this.factura.items[index].productos)
          if (res.data[0].lista == 'unoIgual') {
            this.factura.items[index].productos = null;
            this.factura.items[index].nombre = res.data[0].nombre;
            this.factura.items[index].producto_id = res.data[0].id;
            this.factura.items[index].cantidad = 1;
            this.factura.items[index].precio_sin_igv = res.data[0].precio_sin_igv;
            this.factura.items[index].precio_con_igv = res.data[0].precio_con_igv;
            this.factura.items[index].igv = res.data[0].igv;
            this.factura.items[index].descuento = res.data[0].descuento;
            this.factura.items[index].subtotal = res.data[0].subtotal;
            this.factura.items[index].total = res.data[0].total;
            this.facturaItemsSumTotal();
          } else if (res.data[0].lista == 'ceroNinguno') {
            this.factura.items[index].productos = null;
            this.factura.items[index].cantidad = null;
            this.factura.items[index].precio_con_igv = null;
            this.factura.items[index].subtotal = null;
            this.factura.items[index].total = null;
          } else {
            this.factura.items[index].productos = res.data;
            this.factura.items[index].cantidad = null;
            this.factura.items[index].precio_con_igv = null;
            this.factura.items[index].subtotal = null;
            this.factura.items[index].total = null;
          }
        });

      },
      debitoItemCantidadChange: function (i, item) {
        // console.log(typeof i + ' = ' + i)
        if (this.debito.items[i].precio_con_igv != ''){
          if (this.debito.items[i].cantidad != 0) {
            // los calculos se hacen en base a los precios unitarios con igv y sin igv
            this.debito.items[i].subtotal = (this.debito.items[i].cantidad * this.debito.items[i].precio_sin_igv).toFixed(2);
            this.debito.items[i].total = (this.debito.items[i].cantidad * this.debito.items[i].precio_con_igv).toFixed(2);
            this.debito.items[i].igv = (this.debito.items[i].total - this.debito.items[i].subtotal).toFixed(2);
            this.debitoItemsSumTotal();
          }
        }
      },
      boletaItemCantidadChange: function (i, item) {
        // console.log(typeof i + ' = ' + i)
        if (this.boleta.items[i].cantidad != 0) {
          // los calculos se hacen en base a los precios unitarios con igv y sin igv
          this.boleta.items[i].subtotal = (this.boleta.items[i].cantidad * this.boleta.items[i].precio_sin_igv).toFixed(2);
          this.boleta.items[i].total = (this.boleta.items[i].cantidad * this.boleta.items[i].precio_con_igv).toFixed(2);
          this.boleta.items[i].igv = (this.boleta.items[i].total - this.boleta.items[i].subtotal).toFixed(2);
          this.boletaItemsSumTotal();
        }
      },
      facturaItemCantidadChange: function (i, item) {
        // console.log(typeof i + ' = ' + i)
        if (this.factura.items[i].cantidad != 0) {
          // los calculos se hacen en base a los precios unitarios con igv y sin igv
          this.factura.items[i].subtotal = (this.factura.items[i].cantidad * this.factura.items[i].precio_sin_igv).toFixed(2);
          this.factura.items[i].total = (this.factura.items[i].cantidad * this.factura.items[i].precio_con_igv).toFixed(2);
          this.factura.items[i].igv = (this.factura.items[i].total - this.factura.items[i].subtotal).toFixed(2);
          this.facturaItemsSumTotal();
        }
      },
      debitoItemPrecioChange: function (i, item) {
        // console.log(item.precio_con_igv)
        if (this.debito.items[i].cantidad == null){
          this.debito.items[i].cantidad = 1;
        }
        this.debito.items[i].precio_sin_igv = this.debito.items[i].precio_con_igv - this.debito.items[i].precio_con_igv * 0.18;
        this.debito.items[i].subtotal = (this.debito.items[i].cantidad * this.debito.items[i].precio_sin_igv).toFixed(2);
        this.debito.items[i].total = (this.debito.items[i].cantidad * this.debito.items[i].precio_con_igv).toFixed(2);
        this.debito.items[i].igv = (this.debito.items[i].total - this.debito.items[i].subtotal).toFixed(2);
        this.debitoItemsSumTotal();
        // console.log(item)
      },
      boletaItemPrecioChange: function (i, item) {
        this.boleta.items[i].precio_sin_igv = this.boleta.items[i].precio_con_igv - this.boleta.items[i].precio_con_igv * 0.18;
        this.boleta.items[i].subtotal = (this.boleta.items[i].cantidad * this.boleta.items[i].precio_sin_igv).toFixed(2);
        this.boleta.items[i].total = (this.boleta.items[i].cantidad * this.boleta.items[i].precio_con_igv).toFixed(2);
        this.boleta.items[i].igv = (this.boleta.items[i].total - this.boleta.items[i].subtotal).toFixed(2);
        this.boletaItemsSumTotal();
        // console.log(item)
      },
      facturaItemPrecioChange: function (i, item) {
        this.factura.items[i].precio_sin_igv = this.factura.items[i].precio_con_igv - this.factura.items[i].precio_con_igv * 0.18;
        this.factura.items[i].subtotal = (this.factura.items[i].cantidad * this.factura.items[i].precio_sin_igv).toFixed(2);
        this.factura.items[i].total = (this.factura.items[i].cantidad * this.factura.items[i].precio_con_igv).toFixed(2);
        this.factura.items[i].igv = (this.factura.items[i].total - this.factura.items[i].subtotal).toFixed(2);
        this.facturaItemsSumTotal();
        // console.log(item)
      },
      debitoOpenModal: function (action,debito) {
        if (action == 'nuevo') {
          this.debito.id = '';
          this.debito.numero = '';
          this.debito.tipo = 'debito';
          this.debito.ruc = '';
          this.debito.razon = '';
          this.debito.direccion = '';
          this.debito.serie = this.factura_default;
          this.debito.fecha_emision = '<?php echo date('Y-m-d') ?>';
          this.debito.referencia_numero = null;
          this.debito.referencia_serie = '';
          this.debito.venta_interna = '1';
          this.debito.total_gravadas = null;
          this.debito.total_igv = null;
          this.debito.total_total = null;
          this.debito.items = [{
            id: '',
            productos: [],
            nombre: '',
            producto_id: null,
            unidad: '',
            cantidad: null,
            precio_con_igv: null,
            precio_sin_igv: null,
            igv: null,
            tipo_igv: '1',
            descuento: null,
            subtotal: null,
            total: null
          }];
        } else if (action == 'editar') {
          this.debito.id = debito.id;
          this.debito.tipo = debito.tipo;
          this.debito.ruc = debito.ruc;
          this.debito.razon = debito.razon;
          this.debito.direccion = debito.direccion;
          this.debito.serie = debito.serie;
          this.debito.fecha_emision = debito.fecha_emision;
          this.debito.venta_interna = debito.venta_interna;
          this.debito.total_gravadas = debito.total_gravadas;
          this.debito.total_igv = debito.total_igv;
          this.debito.total_total = debito.total_total;
          this.debito.items = debito.items;
        }
        $('#debitoModal').modal('show')
      },
      boletaOpenModal: function (action, boleta) {
        if (action == 'nuevo') {
          this.boleta.id = '';
          this.boleta.ruc = '10425162531';
          this.boleta.tipo = 'boleta';
          this.boleta.razon = 'Surmotriz S.R.L.';
          this.boleta.direccion = 'Av. Leguia 580';
          this.boleta.serie = this.boleta_default;
          this.boleta.fecha_emision = '<?php echo date('Y-m-d') ?>';
          this.boleta.venta_interna = '1';
          this.boleta.total_gravadas = null;
          this.boleta.total_igv = null;
          this.boleta.total_total = null;
          this.boleta.items = [{
            productos: [],
            nombre: '',
            producto_id: null,
            unidad: '',
            cantidad: null,
            precio_con_igv: null,
            precio_sin_igv: null,
            igv: null,
            tipo_igv: '1',
            descuento: null,
            subtotal: null,
            total: null
          }];
        }
        else if (action == 'editar') {
          this.boleta.id = boleta.id;
          this.boleta.tipo = boleta.tipo;
          this.boleta.ruc = boleta.ruc;
          this.boleta.razon = boleta.razon;
          this.boleta.direccion = boleta.direccion;
          this.boleta.serie = boleta.serie;
          this.boleta.fecha_emision = boleta.fecha_emision;
          this.boleta.venta_interna = boleta.venta_interna;
          this.boleta.total_gravadas = boleta.total_gravadas;
          this.boleta.total_igv = boleta.total_igv;
          this.boleta.total_total = boleta.total_total;
          this.boleta.items = boleta.items;
        }
        $('#boletaModal').modal('show')
        // console.log(this.boleta)
      },
      facturaOpenModal: function (action, factura) {
        if (action == 'nuevo') {
          this.factura.id = '';
          this.factura.tipo = 'factura';
          this.factura.ruc = '';
          this.factura.razon = '';
          this.factura.direccion = '';
          this.factura.serie = this.factura_default;
          this.factura.fecha_emision = '<?php echo date('Y-m-d') ?>';
          this.factura.venta_interna = '1';
          this.factura.total_gravadas = null;
          this.factura.total_igv = null;
          this.factura.total_total = null;
          this.factura.items = [{
            id: '',
            productos: [],
            nombre: '',
            producto_id: null,
            unidad: '',
            cantidad: null,
            precio_con_igv: null,
            precio_sin_igv: null,
            igv: null,
            tipo_igv: '1',
            descuento: null,
            subtotal: null,
            total: null
          }];
        } else if (action == 'editar') {
          this.factura.id = factura.id;
          this.factura.tipo = 'factura';
          this.factura.ruc = factura.ruc;
          this.factura.razon = factura.razon;
          this.factura.direccion = factura.direccion;
          this.factura.serie = factura.serie;
          this.factura.fecha_emision = factura.fecha_emision;
          this.factura.venta_interna = factura.venta_interna;
          this.factura.total_gravadas = factura.total_gravadas;
          this.factura.total_igv = factura.total_igv;
          this.factura.total_total = factura.total_total;
          this.factura.items = factura.items;
          // console.log(factura)
        }
        $('#facturaModal').modal('show')
      },
      debitoAddLine: function () {
        this.debito.items.push({
          id: '',
          nombre: '',
          producto_id: null,
          unidad: '',
          cantidad: null,
          precio_con_igv: 0,
          precio_sin_igv: 0,
          tipo_igv: '0',
          igv: 0,
          descuento: 0,
          subtotal: 0,
          total: 0
        });
      },
      boletaAddLine: function () {
        this.boleta.items.push({
          id: '',
          nombre: '',
          producto_id: null,
          unidad: '',
          cantidad: 0,
          precio_con_igv: 0,
          precio_sin_igv: 0,
          tipo_igv: '0',
          igv: 0,
          descuento: 0,
          subtotal: 0,
          total: 0
        });
      },
      facturaAddLine: function () {
        this.factura.items.push({
          id: '',
          nombre: '',
          producto_id: null,
          unidad: '',
          cantidad: 0,
          precio_con_igv: 0,
          precio_sin_igv: 0,
          tipo_igv: '0',
          igv: 0,
          descuento: 0,
          subtotal: 0,
          total: 0
        });
      },
      creditoOpenModal: function (action, credito) {
        if (action == 'nuevo') {
          this.credito.id = '';
          this.credito.numero = '';
          this.credito.tipo = 'credito';
          this.credito.ruc = '';
          this.credito.razon = '';
          this.credito.direccion = '';
          this.credito.serie = this.factura_default;
          this.credito.fecha_emision = '<?php echo date('Y-m-d') ?>';
          this.credito.venta_interna = '1';
          this.credito.total_gravadas = null;
          this.credito.total_igv = null;
          this.credito.total_total = null;
          this.credito.items = [{
            id: '',
            productos: [],
            nombre: '',
            producto_id: null,
            unidad: '',
            cantidad: null,
            precio_con_igv: null,
            precio_sin_igv: null,
            igv: null,
            tipo_igv: '1',
            descuento: null,
            subtotal: null,
            total: null
          }];
        } else if (action == 'editar') {
          this.credito.id = credito.id;
          this.credito.tipo = credito.tipo;
          this.credito.ruc = credito.ruc;
          this.credito.razon = credito.razon;
          this.credito.direccion = credito.direccion;
          this.credito.serie = credito.serie;
          this.credito.fecha_emision = credito.fecha_emision;
          this.credito.venta_interna = credito.venta_interna;
          this.credito.total_gravadas = credito.total_gravadas;
          this.credito.total_igv = credito.total_igv;
          this.credito.total_total = credito.total_total;
          this.credito.items = credito.items;
        }
        $('#creditoModal').modal('show')
      }
    },
    created() {
      this.facturaList();
      this.facturaSeries();
      // this.facturaCreditoSeries();
      // this.facturaDebitoSeries();
      this.boletaSeries();
      // this.boletaCreditoSeries();
      // this.boletaDebitoSeries();
    }
  });
</script>
