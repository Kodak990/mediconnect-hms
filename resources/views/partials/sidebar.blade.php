<nav class="sidebar">
    <div class="nav-section">Overview</div>
    <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <span class="nav-icon">📊</span> Dashboard
    </a>

    @if(in_array(auth()->user()->role, ['admin','doctor','nurse']))
    <div class="nav-section">Patient Care</div>
    <a class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">
        <span class="nav-icon">👥</span> Patients
        <span class="nav-badge">{{ \App\Models\Patient::count() }}</span>
    </a>
    <a class="nav-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
        <span class="nav-icon">📅</span> Appointments
        <span class="nav-badge">{{ \App\Models\Appointment::where('status','pending')->count() }}</span>
    </a>
    <a class="nav-item {{ request()->routeIs('queue.*') ? 'active' : '' }}" href="{{ route('queue.index') }}">
        <span class="nav-icon">🚶</span> Queue
        <span class="nav-badge">{{ \App\Models\QueueEntry::whereDate('created_at', now())->whereIn('status',['waiting','in_progress'])->count() }}</span>
    </a>
    @endif
    @if(in_array(auth()->user()->role, ['admin','doctor']))
    <a class="nav-item {{ request()->routeIs('telemedicine.*') ? 'active' : '' }}" href="{{ route('telemedicine.index') }}">
        <span class="nav-icon">📹</span> Telemedicine
        <span class="nav-badge">{{ \App\Models\TelemedicineSession::whereIn('status',['scheduled','in_progress'])->count() }}</span>
    </a>
    @endif

    @if(in_array(auth()->user()->role, ['admin','doctor','nurse','lab']))
    <div class="nav-section">Clinical</div>
    @endif
    @if(in_array(auth()->user()->role, ['admin','doctor','nurse']))
    <a class="nav-item {{ request()->routeIs('consultations.*') ? 'active' : '' }}" href="{{ route('consultations.index') }}">
        <span class="nav-icon">📋</span> Consultations
        <span class="nav-badge">{{ \App\Models\Consultation::where('status','in_progress')->count() }}</span>
    </a>
    <a class="nav-item {{ request()->routeIs('prescriptions.*') ? 'active' : '' }}" href="{{ route('prescriptions.index') }}">
        <span class="nav-icon">💊</span> Prescriptions
        <span class="nav-badge">{{ \App\Models\Prescription::where('status','active')->count() }}</span>
    </a>
    @endif
    @if(in_array(auth()->user()->role, ['admin','doctor','nurse','lab']))
    <a class="nav-item {{ request()->routeIs('lab-results.*') ? 'active' : '' }}" href="{{ route('lab-results.index') }}">
        <span class="nav-icon">🔬</span> Lab Results
        <span class="nav-badge red">{{ \App\Models\LabResult::where('status','abnormal')->count() }}</span>
    </a>
    @endif

    @if(in_array(auth()->user()->role, ['admin','billing']))
    <div class="nav-section">Administration</div>
    <a class="nav-item {{ request()->routeIs('billing.*') ? 'active' : '' }}" href="{{ route('billing.index') }}">
        <span class="nav-icon">💳</span> Billing
        <span class="nav-badge red">{{ \App\Models\Invoice::where('status','pending')->count() }}</span>
    </a>
    @endif
    @if(auth()->user()->role === 'admin')
    <a class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
        <span class="nav-icon">👤</span> Users
        <span class="nav-badge">{{ \App\Models\User::count() }}</span>
    </a>
    <a class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
        <span class="nav-icon">📈</span> Reports
    </a>
    @endif

    <div class="sidebar-footer">
        MediConnect v1.0<br>© 2026 All rights reserved
    </div>
</nav>