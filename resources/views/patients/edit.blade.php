<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Edit Patient</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-dark: #064e3b; --teal: #0d7c66; --teal-mid: #14a085;
            --teal-lite: #ecfdf5; --teal-glow: rgba(13,124,102,0.15);
            --white: #ffffff; --ink: #0f1f1b; --ink-mid: #374151;
            --ink-lite: #6b7280; --border: #d1fae5; --cream: #f0fdf8;
            --error: #dc2626; --error-bg: #fef2f2;
        }

        body { font-family: 'Inter', sans-serif; background: var(--cream); color: var(--ink); min-height: 100vh; }

        .topbar { height: 62px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 28px; gap: 16px; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-brand { display: flex; align-items: center; gap: 10px; flex: 1; }
        .topbar-brand .icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .topbar-brand h1 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--teal-dark); }
        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-mid); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; }

        .layout { display: flex; }

        .sidebar { width: 240px; background: var(--white); border-right: 1px solid var(--border); padding: 20px 0; position: sticky; top: 62px; height: calc(100vh - 62px); overflow-y: auto; display: flex; flex-direction: column; }
        .nav-section { padding: 16px 20px 6px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ink-lite); }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: var(--ink-mid); font-size: 14px; border-left: 3px solid transparent; transition: all 0.15s; font-weight: 500; text-decoration: none; }
        .nav-item:hover { background: var(--teal-lite); color: var(--teal); }
        .nav-item.active { background: var(--teal-lite); color: var(--teal); border-left-color: var(--teal); font-weight: 600; }
        .nav-icon { font-size: 16px; width: 22px; text-align: center; }
        .nav-badge { margin-left: auto; background: var(--teal); color: white; border-radius: 20px; font-size: 10px; padding: 2px 8px; font-weight: 700; }
        .nav-badge.red { background: #ef4444; }
        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid var(--border); font-size: 12px; color: var(--ink-lite); }

        .main { flex: 1; padding: 28px 32px; }

        .breadcrumb { display: flex; gap: 8px; align-items: center; font-size: 13px; color: var(--ink-lite); margin-bottom: 20px; }
        .breadcrumb a { color: var(--teal); text-decoration: none; font-weight: 500; }

        .page-header { margin-bottom: 24px; }
        .page-header h2 { font-family: 'Playfair Display', serif; font-size: 1.65rem; color: var(--ink); }
        .page-header p { color: var(--ink-lite); font-size: 14px; margin-top: 3px; }

        .card { background: var(--white); border-radius: 12px; padding: 28px 32px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); max-width: 820px; }

        .section-title { font-size: 13px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px; }
        .form-grid.three { grid-template-columns: 1fr 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }

        label { font-size: 13px; font-weight: 600; color: var(--ink-mid); }

        input, select, textarea { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
        input:focus, select:focus, textarea:focus { border-color: var(--teal); box-shadow: 0 0 0 3px var(--teal-glow); }
        textarea { resize: vertical; min-height: 80px; }
        .field-error { color: var(--error); font-size: 12px; }

        .form-footer { display: flex; gap: 12px; align-items: center; padding-top: 20px; border-top: 1px solid var(--border); margin-top: 8px; }

        .btn { padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: linear-gradient(135deg, var(--teal-dark), var(--teal)); color: white; box-shadow: 0 2px 10px rgba(13,124,102,0.3); }
        .btn-primary:hover { transform: translateY(-1px); }
        .btn-ghost { background: var(--white); color: var(--ink-mid); border: 1.5px solid var(--border); }
        .btn-ghost:hover { background: var(--cream); }

        .error-bag { background: var(--error-bg); border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }
    </style>
</head>
<body>

<header class="topbar">
    <div class="topbar-brand">
        <div class="icon">🏥</div>
        <h1>MediConnect</h1>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Sign Out</button>
    </form>
</header>

<div class="layout">

    @include('partials.sidebar')

    <main class="main">

        <div class="breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span>›</span>
            <a href="{{ route('patients.show', $patient) }}">{{ $patient->full_name }}</a>
            <span>›</span>
            <span>Edit</span>
        </div>

        <div class="page-header">
            <h2>Edit Patient</h2>
            <p>Update {{ $patient->full_name }}'s medical record.</p>
        </div>

        @if ($errors->any())
            <div class="error-bag">
                @foreach ($errors->all() as $error)
                    <p>⚠ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card">
            <form method="POST" action="{{ route('patients.update', $patient) }}">
                @csrf
                @method('PATCH')

                <div class="section-title">Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required/>
                        @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required/>
                        @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required/>
                        @error('date_of_birth')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Gender *</label>
                        <select name="gender" required>
                            <option value="Male"   {{ old('gender', $patient->gender)=='Male'   ? 'selected':'' }}>Male</option>
                            <option value="Female" {{ old('gender', $patient->gender)=='Female' ? 'selected':'' }}>Female</option>
                        </select>
                        @error('gender')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Phone Number *</label>
                        <input type="tel" name="phone" value="{{ old('phone', $patient->phone) }}" required/>
                        @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $patient->email) }}" placeholder="patient@example.com"/>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>State of Origin</label>
                        <input type="text" name="state_of_origin" value="{{ old('state_of_origin', $patient->state_of_origin) }}"/>
                    </div>
                    <div class="form-group full">
                        <label>Address</label>
                        <textarea name="address">{{ old('address', $patient->address) }}</textarea>
                    </div>
                </div>

                <div class="section-title">Medical Information</div>
                <div class="form-grid three">
                    <div class="form-group">
                        <label>Blood Group *</label>
                        <select name="blood_group" required>
                            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group', $patient->blood_group)==$bg ? 'selected':'' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                        @error('blood_group')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Genotype</label>
                        <select name="genotype">
                            <option value="">Select</option>
                            @foreach(['AA','AS','SS','AC'] as $gt)
                                <option value="{{ $gt }}" {{ old('genotype', $patient->genotype)==$gt ? 'selected':'' }}>{{ $gt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Known Allergies</label>
                        <input type="text" name="allergies" value="{{ old('allergies', $patient->allergies) }}"/>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active"   {{ old('status', $patient->status)=='active'   ? 'selected':'' }}>Active</option>
                            <option value="inactive" {{ old('status', $patient->status)=='inactive' ? 'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-ghost">Cancel</a>
                </div>

            </form>
        </div>

    </main>
</div>

</body>
</html>