<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
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
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body class="hold-transition login-page">

<div class="login-box pt-lg-5" id="app">
  <div class="login-logo">
    <a href="../../index2.html"><b>Iniciar </b>Session {{nombre}}</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar Session </p>

      <form @submit.prevent="logear">
        <div class="input-group mb-3">
          <input type="email" class="form-control" v-model="login.email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" v-model="login.password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recordar Contrasenia
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="/view/auth/forgot.php">Olvide mi contrasenia</a>
      </p>
      <p class="mb-0">
        <a href="/view/auth/register.php" class="text-center">Registrarme</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/plugins/dist/js/adminlte.min.js"></script>
<!-- Vue js-->
<script>
  Vue.config.productionTip = false;
  var app = new Vue({
    el: '#app',
    data: {
      nombre: 'moises',
      login: {
        email: '',
        password: ''
      }
    },
    methods: {
      logear: function () {
        axios.post('_auth.php?f=login', {login: this.login}).then(res => {
          if (res.data == 'ok') {
            Swal.fire({
              title: 'Iniciar Session!',
              text: 'Correcto!',
              icon: 'success',
              confirmButtonText: 'Entrar'
            }).then((result) => {
              window.location.href = "/view/documentos/";
            });
          }
          console.log(res.data)
        })
      }
    }
  })
</script>
</body>
</html>
