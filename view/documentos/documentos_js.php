<script>
    var app = new Vue({
        el: '#app',
        data: {
            nombre: 'moises',            
            factura: {
                id: ''
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
            facturaOpenModal: function(action) {
                if (action == 'nuevo'){
                    this.factura.id = '';                    
                }else if (action == 'editar'){                    
                }
                
                $('#facturaModal').modal('show')
            },
            boletaOpenModal: function(action) {
                $('#boletaModal').modal('show')
            },
            creditoOpenModal: function(action) {
                $('#creditoModal').modal('show')
            },
            debitoOpenModal: function(action) {
                $('#debitoModal').modal('show')
            }
        }
    });
</script>