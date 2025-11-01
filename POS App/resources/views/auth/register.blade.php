<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register | POS Admin</title>

  <!-- Fonts -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    crossorigin="anonymous"
  />

  <!-- Bootstrap & Icons -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  />

  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>

<body class="register-page bg-body-secondary">
  <div class="register-box">
    <div class="card card-outline card-primary shadow-sm">
      <div class="card-header text-center">
        <h1 class="mb-0"><b>POS</b> App</h1>
      </div>

      <div class="card-body register-card-body">
        <p class="register-box-msg">Register a new admin</p>

        <!-- REGISTER FORM -->
        <form action="{{ route('register.post') }}" method="POST">
          @csrf

          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                required
                placeholder="Full Name"
              />
              <label for="name">Full Name</label>
            </div>
            <span class="input-group-text"><i class="bi bi-person"></i></span>
          </div>

          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
                placeholder="Email"
              />
              <label for="email">Email</label>
            </div>
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          </div>

          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input
                id="password"
                name="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                placeholder="Password"
              />
              <label for="password">Password</label>
            </div>
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          </div>

          @if($errors->any())
            <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
          @endif

          <div class="row mt-3 mb-3 d-flex justify-content-center">
            <div class="col-4">
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </div>
          </div>
        </form>

        <p class="mb-0 text-center">
          Already have an account? 
          <a href="/" class="text-decoration-none">Log in</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>