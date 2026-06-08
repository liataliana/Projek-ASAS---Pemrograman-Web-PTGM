<x-guest-layout>

<style>
.welcome{
    text-align:center;
    color:white;
    margin-bottom:25px;
}

.welcome h2{
    font-size:28px;
    margin-bottom:5px;
}

.welcome p{
    color:#dbeafe;
    font-size:14px;
}

.form-group{
    margin-bottom:18px;
}

.form-label{
    display:block;
    color:white;
    margin-bottom:8px;
    font-weight:600;
}

.form-input{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:rgba(255,255,255,.15);
    color:white;
    outline:none;
}

.form-input::placeholder{
    color:#cbd5e1;
}

.btn-login{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:#3b82f6;
    color:white;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-login:hover{
    background:#2563eb;
}

.links{
    margin-top:15px;
    text-align:center;
}

.links a{
    color:#dbeafe;
    text-decoration:none;
    font-size:14px;
}

.links a:hover{
    text-decoration:underline;
}
html, body {
    height: 100%;
    margin: 0;
    overflow-y: auto;
}
</style>

<div class="welcome">
    <h2>Daftar Akun 📝</h2>
    <p>Buat akun untuk mulai pakai KlikRental</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label class="form-label">Nama</label>
        <input type="text"
               name="name"
               class="form-input"
               placeholder="Masukkan Nama"
               value="{{ old('name') }}"
               required>
    </div>

    <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-input"
               placeholder="Masukkan Email"
               value="{{ old('email') }}"
               required>
    </div>

    <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password"
               name="password"
               class="form-input"
               placeholder="Masukkan Password"
               required>
    </div>

    <div class="form-group">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-input"
               placeholder="Ulangi Password"
               required>
    </div>

    <button type="submit" class="btn-login">
        DAFTAR SEKARANG
    </button>

    <div class="links">
        <a href="{{ route('login') }}">
            Sudah punya akun? Login
        </a>
    </div>

</form>

</x-guest-layout>