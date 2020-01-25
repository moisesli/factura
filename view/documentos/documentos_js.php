<script>
    var app = new Vue({
        el: '#app',
        data: {
            nombre: 'moises',
            factura: {},
            boleta: {},
            nota: {},
            debito: {}
        },
        methods: {
            facturaOpenModalNew: function() {
                console.log('open modal')
                $('#facturaModalNew').modal('show')
            },
            boletaOpenModalNew: function() {
                $('#boletaModalNew').modal('show')
            },
            notaOpenModalNew: function() {

            },
            debitoOpenModalNew: function() {

            }
        }
    });
</script>