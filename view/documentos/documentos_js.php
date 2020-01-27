<script>
    var app = new Vue({
        el: '#app',
        data: {
            nombre: 'moises',            
            factura: {
                id: '',
                
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
                if (action == 'nuevo'){
                    this.boleta.id = '';                    
                }else if (action == 'editar'){  
                                      
                }
                $('#boletaModal').modal('show')
            },
            creditoOpenModal: function(action) {
                if (action == 'nuevo'){
                    this.credito.id = '';                    
                }else if (action == 'editar'){  
                                      
                }
                $('#creditoModal').modal('show')
            },
            debitoOpenModal: function(action) {
                if (action == 'nuevo'){
                    this.debito.id = '';                    
                }else if (action == 'editar'){  
                                      
                }
                $('#debitoModal').modal('show')
            }
        }
    });
</script>