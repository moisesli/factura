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
         facturaItemNombreChange: function(index, item, text) {
            // console.log(text);
            // this.factura.items[index].cantidad = 1;

            axios.post('./_documentos.php?f=searchproductos', {
               text: text
            }).then(res => {
               console.log(res.data)
               // console.log(this.factura.items[index].productos)               
               if (res.data == 'unoIgual') {
                  this.factura.items[index].productos = null;
               } else if (res.data == 'ceroNinguno') {
                  this.factura.items[index].productos = null;
               } else {
                  this.factura.items[index].productos = res.data;
               }                             
            });

         },
         facturaItemCantidadChange: function(item) {
            console.log(item)
         },
         facturaItemPrecioChange: function(item) {
            console.log(item)
         },
         facturaItemTotalChange: function(item) {
            console.log(item)
         },
         facturaOpenModal: function(action) {
            if (action == 'nuevo') {
               this.factura.id = '';
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