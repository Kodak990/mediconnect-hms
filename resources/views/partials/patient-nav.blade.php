<header class="portal-topbar">
    <div class="portal-brand">
        <div class="brand-icon">🏥</div>
        <span class="brand-name">MediConnect</span>
        <span class="brand-tag">Patient Portal</span>
    </div>

    <nav class="portal-nav">
        <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"
           href="{{ route('patient.dashboard') }}">
            🏠 Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('patient.appointments') ? 'active' : '' }}"
           href="{{ route('patient.appointments') }}">
            📅 Appointments
        </a>
        <a class="nav-link {{ request()->routeIs('patient.prescriptions') ? 'active' : '' }}"
           href="{{ route('patient.prescriptions') }}">
            💊 Prescriptions
        </a>
        <a class="nav-link {{ request()->routeIs('patient.lab-results') ? 'active' : '' }}"
           href="{{ route('patient.lab-results') }}">
            🔬 Lab Results
        </a>
        <a class="nav-link {{ request()->routeIs('patient.bills') ? 'active' : '' }}"
           href="{{ route('patient.bills') }}">
            💳 My Bills
        </a>
    </nav>

    <div class="portal-user">
        <span class="user-name">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Sign Out</button>
        </form>
    </div>
</header>