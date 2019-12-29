<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Registration Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/plugins/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Vue.js -->
    <script src="/plugins/vue/vue.js"></script>
    <!-- Axios -->
    <script src="/plugins/vue/axios.min.js"></script>
</head>
<body class="hold-transition register-page">
<div class="register-box" id="app">
    <div class="register-logo">
        <a href="../../index2.html"><b>Lineysoft</b>.com {{nombre}}</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Registro de Empresa</p>

            <form v-on:submit.prevent="Registrar">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Empresa RUC" v-model="register.ruc">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Empresa Razon Social" v-model="register.razon_social">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Usuario Email" v-model="register.email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Usuario Contraseña" v-model="register.password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                Acepto los <a href="#">terminos</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block" :disabled="isDisabled">
                          <i class="fa fa-lock-open"></i> Registrarse
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="/view/auth/login.php" class="text-center">Ya tengo una cuenta</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/plugins/dist/js/adminlte.min.js"></script>
<!-- Code Vue -->
<script>
  var app = new Vue({
    el: '#app',
    data: {
      nombre: "moises",
      register: {
        ruc: '',
        razon_social: '',
        email: '',
        password: ''
      }
    },
    methods: {
      Registrar: function () {
        console.log(this.register)
      }
    },
    computed: {
      isDisabled: function () {
        return this.register.ruc.length &&
          this.register.razon_social.length &&
          this.register.email.length &&
          this.register.password.length == 0;
      }
    }
  })
</script>
</body>
</html>
