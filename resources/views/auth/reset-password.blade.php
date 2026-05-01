@extends('layout', ['includeNavbar' => false])
@section('title', 'Reset Password')

@section('content')
<style>
/* === Palette et base === */
/* === Palette === */
:root {
  --bg: #f4f7fb;
  --card: #ffffff;
  --text: #1e293b;
  --muted: #64748b;
  --primary: rgb(147, 192, 221);
  --primary-gradient: linear-gradient(135deg, #2aa9fb, #37e1c3);
}

/* === Page Center === */
html, body {
  height: 100%;
  margin: 0;
  font-family: "Inter", system-ui, sans-serif;
  background: radial-gradient(circle at 20% 0%, rgba(42,169,251,.12), transparent 40%),
              var(--bg);
  display: flex;
  align-items: center;
  justify-content: center;
}

/* === Login Box === */
.login-box {
  width: 400px;
  max-width: 92%;
}

/* === Card === */
.card {
  background: var(--card);
  border-radius: 18px;
  border: none;
  box-shadow: 0 15px 40px rgba(0,0,0,0.08);
  overflow: hidden;
  transition: 0.3s ease;
}

.card:hover {
  transform: translateY(-4px);
}

/* === Header === */
.card-header {
  background: var(--primary-gradient);
  text-align: center;
  padding: 30px 0;
}

.card-header img {
  width: 75px;
  margin-bottom: 10px;
}

.card-header .h1 {
  color: #fff;
  font-weight: 700;
  font-size: 1.4rem;
  margin: 0;
}

/* === Body === */
.card-body {
  padding: 30px;
}

.login-box-msg {
  text-align: center;
  color: var(--muted);
  margin-bottom: 25px;
  font-size: 0.95rem;
}

/* === Inputs === */
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

.error-border {
  border-color: #ef4444 !important;
}

/* === Icons === */
.input-group-text {
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 0 12px 12px 0;
  color: var(--muted);
}

/* === Error Messages === */
.error {
  color: #ef4444;
  font-size: 0.85rem;
  margin-top: -8px;
  margin-bottom: 12px;
}

/* === Button === */
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

.btn-primary:hover {
  transform: translateY(-2px);
  opacity: 0.95;
}
.forgot-link {
  display: inline-block;
  margin-top: 15px;
  font-size: 0.9rem;
  color: #2aa9fb;
  text-decoration: none;
  transition: 0.3s ease;
}

.forgot-link:hover {
  text-decoration: underline;
}
/* === Responsive === */
@media (max-width: 600px) {
  .card-header img {
    width: 60px;
  }
}
</style>
<div class="login-box">
    <div class="card">
        <div class="card-header">
            <img src="{{ asset('img/logo.png') }}">
            <h1 class="h1">SmartHospital.tn</h1>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <input type="email" name="email"
                       class="form-control mb-3"
                       placeholder="Email" required>

                <input type="password" name="password"
                       class="form-control mb-3"
                       placeholder="New password" required>

                <input type="password" name="password_confirmation"
                       class="form-control mb-3"
                       placeholder="Confirm password" required>

                <button type="submit" class="btn btn-primary">
                    Reset Password
                </button>
            </form>

        </div>
    </div>
</div>

@endsection