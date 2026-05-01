@extends('layout', ['includeNavbar' => false])
@section('title', 'Log in')

@section('content')

<style>
:root {
  --bg: #f4f7fb;
  --card: #ffffff;
  --text: #1e293b;
  --muted: #64748b;
  --primary: rgb(147, 192, 221);
  --primary-gradient: linear-gradient(135deg, #2aa9fb, #37e1c3);
}

/* Page Center */
html, body {
  height: 100%;
  margin: 0;
  font-family: "Inter", system-ui, sans-serif;
  background: radial-gradient(circle at 20% 0%, rgba(42,169,251,.12), transparent 40%), var(--bg);
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Login Box */
.login-box {
  width: 500px;
  max-width: 95%;
}

/* Card */
.card {
  background: var(--card);
  border-radius: 18px;
  border: none;
  box-shadow: 0 15px 40px rgba(0,0,0,0.08);
  overflow: hidden;
  transition: 0.3s ease;
}
.card:hover { transform: translateY(-4px); }

/* Header */
.card-header {
  background: var(--primary-gradient);
  text-align: center;
  padding: 30px 0;
}
.card-header img { width: 75px; margin-bottom: 10px; }
.card-header .h1 { color: #fff; font-weight: 700; font-size: 1.4rem; margin: 0; }

/* Body */
.card-body { padding: 30px; }
.login-box-msg {
  text-align: center;
  color: var(--muted);
  margin-bottom: 2px;
  font-size: 0.95rem;
}

/* Inputs */
.form-control {
  padding: 12px 15px;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  font-size: 0.95rem;
  color: var(--text);
  transition: 0.3s ease;
}
.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(42,169,251,0.15);
  background: #fff;
  outline: none;
}
.error-border { border-color: #ef4444 !important; }

/* Icons */
.input-group-text {
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 0 12px 12px 0;
  color: var(--muted);
}

/* Error Messages */
.error-message {
  color: #ef4444;
  font-size: 0.85rem;
  margin-top: 4px;
  margin-bottom: 12px;
  text-align: left;
}

/* Button */
.btn-primary {
  background: var(--primary-gradient);
  border: none;
  border-radius: 12px;
  padding: 12px;
  font-weight: 600;
  color: #ffffff;
  width: 100%;
  transition: 0.3s ease;
  box-shadow: 0 8px 18px rgba(42,169,251,0.25);
}
.btn-primary:hover { transform: translateY(-2px); opacity: 0.95; }

/* Checkbox & Links */
.form-check { margin-bottom: 15px; font-size: 0.9rem; color: var(--text); }
.form-check-input { margin-right: 8px; }
.forgot-link {
  display: inline-block;
  margin-top: 15px;
  font-size: 0.9rem;
  color: #2aa9fb;
  text-decoration: none;
  transition: 0.3s ease;
}
.forgot-link:hover { text-decoration: underline; }

/* Responsive */
@media (max-width: 600px) {
  .card-header img { width: 600px; }
}
</style>

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <img src="{{ asset('img/logo.png') }}" alt="SmartHospital.tn">
            <h1 class="h1">SmartHospital.tn</h1>
        </div>

        <div class="card-body" role="form" aria-label="Formulaire de connexion">

            {{-- Message d'erreur uniquement dans le card login --}}
            @if ($errors->any())
                <div class="error-message">
                    <ul class="m-0 p-0" style="list-style:none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('login') }}" method="post" autocomplete="off">
                @csrf

                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="form-control @error('email') error-border @enderror"
                           placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') error-border @enderror"
                           placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="form-check-label">Remember Me</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection