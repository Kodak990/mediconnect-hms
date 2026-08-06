<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Patient Portal</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --teal-dark: #064e3b; --teal: #0d7c66; --teal-lite: #ecfdf5; --white: #ffffff; --ink: #0f1f1b; --ink-lite: #6b7280; --border: #d1fae5; --cream: #f0fdf8; }
        body { font-family: 'Inter', sans-serif; background: var(--cream); min-height: 100vh; }
        .topbar { height: 62px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 28px; gap: 10px; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar .icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .topbar h1 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--teal-dark); flex: 1; }
        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-lite); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; }
        .wrap { display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 62px); padding: 40px 20px; }
        .card { background: var(--white); border-radius: 16px; padding: 48px 40px; border: 1px solid var(--border); box-shadow: 0 4px 20px rgba(0,0,0,0.06); max-width: 480px; text-align: center; }
        .icon-big { font-size: 56px; margin-bottom: 16px; }
        .card h2 { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--ink); margin-bottom: 10px; }
        .card p { color: var(--ink-lite); font-size: 14.5px; line-height: 1.6; }
    </style>
</head>
<body>
<header class="topbar">
    <div class="icon">🏥</div>
    <h1>MediConnect</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Sign Out</button>
    </form>
</header>
<div class="wrap">
    <div class="card">
        <div class="icon-big">🔍</div>
        <h2>No Patient Record Found</h2>
        <p>Your account ({{ auth()->user()->email }}) hasn't been linked to a patient record yet. Please contact the hospital reception desk and they'll get this sorted for you.</p>
    </div>
</div>
</body>
</html>