```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>KlikRental</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
     margin:0;
    min-height:100vh;
    overflow:hidden;

    background:linear-gradient(
        to right,
        #0f172a 0%,
        #1e3a8a 50%,
        #2563eb 100%
    );

    background-repeat:no-repeat;
    background-size:100% 100%;
}

.container{
    width:100%;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:30px;
    gap:60px;
}

/* LOGIN */
.left-side{
    width:420px;
    flex-shrink:0;
}

.login-card{
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,.15);
    border-radius:25px;
    padding:30px;
    box-shadow:0 15px 35px rgba(0,0,0,.2);
}

/* BRANDING */
.right-side{
    max-width:550px;
    color:white;
}

.logo{
    font-size:85px;
    margin-bottom:10px;
}

.right-side h1{
    font-size:58px;
    font-weight:700;
    margin-bottom:10px;
}

.right-side p{
    font-size:18px;
    color:#dbeafe;
    line-height:1.6;
    margin-bottom:25px;
}

.features{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.feature{
    background:rgba(255,255,255,.12);
    padding:14px;
    border-radius:12px;
    text-align:center;
}

/* RESPONSIVE */
@media(max-width:900px){

    body{
        overflow:auto;
    }

    .container{
        flex-direction:column;
        gap:30px;
        height:auto;
        min-height:100vh;
    }

    .left-side{
        width:100%;
        max-width:450px;
    }

    .right-side{
        text-align:center;
        max-width:450px;
    }

    .right-side h1{
        font-size:42px;
    }

    .logo{
        font-size:70px;
    }

    .features{
        grid-template-columns:1fr;
    }
}
</style>

</head>
<body>

<div class="container">

    <div class="left-side">
        <div class="login-card">
            {{ $slot }}
        </div>
    </div>

    <div class="right-side">

        <div class="logo">💻</div>

        <h1>KlikRental</h1>

        <p>
            Solusi rental laptop cepat, aman dan terpercaya
            untuk kebutuhan belajar, kerja, maupun proyek.
        </p>

        <div class="features">
            <div class="feature">✅ Booking Online</div>
            <div class="feature">✅ Harga Terjangkau</div>
            <div class="feature">✅ Laptop Berkualitas</div>
            <div class="feature">✅ Support Cepat</div>
        </div>

    </div>

</div>

</body>
</html>
```
