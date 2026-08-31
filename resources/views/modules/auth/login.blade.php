@extends('layouts.auth')

@section('title', 'Iniciar Sesión | Sistema de Ventas')

@section('content')
<main class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>Sistema</b> Ventas</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para ingresar al sistema</p>

      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
          <input
            id="email"
            name="email"
            type="email"
            class="form-control"
            placeholder="Correo electrónico"
            required
            autofocus
          />
          <div class="input-group-text">
            <span class="bi bi-envelope"></span>
          </div>
        </div>

        <div class="input-group mb-3">
          <input
            id="password"
            name="password"
            type="password"
            class="form-control"
            placeholder="Contraseña"
            required
          />
          <div class="input-group-text">
            <span class="bi bi-lock-fill"></span>
          </div>
        </div>

        <!--begin::Row-->
        <div class="row">
          <div class="col-8">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" />
              <label class="form-check-label" for="rememberMe"> Recordarme </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!--end::Row-->
      </form>

      <p class="mb-1 mt-3 text-center">
        <a href="#">Olvidé mi contraseña</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</main>
@endsection
