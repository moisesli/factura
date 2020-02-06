<script>
  var app = new Vue({
    el: '#app',
    data: {
      nombre: 'moises',
      productosList: [],
      factura: {
        id: '',
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
          productos: [],
          nombre: '',
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
      boleta: {
        id: ''
      },
      nota: {
        id: ''
      },
      debito: {
        id: ''
      }
    },
    methods: {
      facturaSave: function(){
        console.log(this.factura)
      },
      facturaItemsSumTotal: function() {
        
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
      facturaItemNombreChange: function(index, item, text) {
        // console.log(text);

        axios.post('./_documentos.php?f=searchproductos', {
          text: text
        }).then(res => {
          // console.log(this.factura.items[index].productos)
          if (res.data[0].lista == 'unoIgual') {
            this.factura.items[index].productos = null;
            this.factura.items[index].cantidad = 1;
            this.factura.items[index].precio_con_igv = res.data[0].precio_con_igv;
            this.factura.items[index].igv = res.data[0].igv;
            this.factura.items[index].precio_sin_igv = res.data[0].precio_sin_igv;
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
      facturaItemCantidadChange: function(i, item) {
        // console.log(typeof i + ' = ' + i)
        if (this.factura.items[i].cantidad != 0) {
          // los calculos se hacen en base a los precios unitarios con igv y sin igv
          this.factura.items[i].subtotal = (this.factura.items[i].cantidad * this.factura.items[i].precio_sin_igv).toFixed(2);
          this.factura.items[i].total = (this.factura.items[i].cantidad * this.factura.items[i].precio_con_igv).toFixed(2);
          this.factura.items[i].igv = (this.factura.items[i].total - this.factura.items[i].subtotal).toFixed(2);
          this.facturaItemsSumTotal();
        }
      },
      facturaItemPrecioChange: function(i, item) {
        this.factura.items[i].precio_sin_igv = this.factura.items[i].precio_con_igv - this.factura.items[i].precio_con_igv * 0.18;
        this.factura.items[i].subtotal = (this.factura.items[i].cantidad * this.factura.items[i].precio_sin_igv).toFixed(2);
        this.factura.items[i].total = (this.factura.items[i].cantidad * this.factura.items[i].precio_con_igv).toFixed(2);
        this.factura.items[i].igv = (this.factura.items[i].total - this.factura.items[i].subtotal).toFixed(2);
        this.facturaItemsSumTotal();
        // console.log(item)
      },
      facturaOpenModal: function(action) {
        if (action == 'nuevo') {
          this.factura.id = '';
          this.factura.ruc = '';
          this.factura.razon = '';
          this.factura.direccion = '';
          this.factura.serie = '';
          this.factura.fecha_emision = '';
          this.factura.venta_interna = '';
          this.factura.total_gravadas = null;
          this.factura.total_igv = null;
          this.factura.total_total = null;
          this.factura.items = [{
            productos: [],
            nombre: '',
            unidad: '',
            cantidad: null,
            precio_con_igv: null,
            precio_sin_igv: null,
            igv: null,
            tipo_igv: '0',
            descuento: null,
            subtotal: null,
            total: null
          }];
        } else if (action == 'editar') {

        }
        $('#facturaModal').modal('show')
      },
      facturaAddLine: function() {
        this.factura.items.push({
          nombre: '',
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
      boletaOpenModal: function(action) {
        if (action == 'nuevo') {
          this.boleta.id = '';
        } else if (action == 'editar') {

        }
        $('#boletaModal').modal('show')
      },
      creditoOpenModal: function(action) {
        if (action == 'nuevo') {
          this.credito.id = '';
        } else if (action == 'editar') {

        }
        $('#creditoModal').modal('show')
      },
      debitoOpenModal: function(action) {
        if (action == 'nuevo') {
          this.debito.id = '';
        } else if (action == 'editar') {

        }
        $('#debitoModal').modal('show')
      }
    }
  });
</script>