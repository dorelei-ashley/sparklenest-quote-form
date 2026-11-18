<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get Your Free Quote | SparkleNest</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal: #14A39A;
            --navy: #0F2A3D;
            --yellow: #FFC857;
            --mint: #F6FBFA;
            --gray: #4A5B68;
            --border: #D5E3E1;
            --error: #B42318;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 16px;
            color: var(--navy);
            background: var(--mint);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }
        .card {
            width: 100%;
            max-width: 480px;
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(15, 42, 61, 0.10);
        }
        .logo { font-family: 'Poppins', sans-serif; color: var(--teal); font-size: 20px; margin: 0 0 16px; }
        h1 { font-family: 'Poppins', sans-serif; font-size: 26px; margin: 0 0 4px; }
        .sub { color: var(--gray); margin: 0 0 20px; font-size: 15px; }

        .progress { display: flex; gap: 8px; margin-bottom: 20px; }
        .progress div { flex: 1; font-size: 14px; color: var(--gray); border-top: 4px solid var(--border); padding-top: 6px; }
        .progress div.active { color: var(--teal); border-top-color: var(--teal); font-weight: 600; }

        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 14px; }
        input[type=text], input[type=tel], input[type=email], input[type=date], select {
            display: block;
            width: 100%;
            height: 48px;
            margin-top: 6px;
            padding: 0 14px;
            font: inherit;
            font-weight: 400;
            color: var(--navy);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
        }
        input:focus, select:focus { outline: 2px solid var(--teal); outline-offset: 1px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .consent { display: flex; gap: 10px; align-items: flex-start; font-weight: 400; font-size: 14px; color: var(--gray); }
        .consent input { margin-top: 3px; width: 18px; height: 18px; accent-color: var(--teal); flex-shrink: 0; }

        .btn {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 12px;
            background: var(--yellow);
            color: var(--navy);
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }
        .btn:hover { filter: brightness(0.96); }
        .btn:disabled { opacity: 0.7; cursor: not-allowed; }
        .btn-link { background: none; border: 0; color: var(--teal); font: inherit; font-weight: 600; cursor: pointer; margin-top: 12px; width: 100%; }
        .micro { text-align: center; font-size: 14px; color: var(--gray); margin: 12px 0 0; }

        .errors { background: #FEF3F2; border: 1px solid #FECDCA; color: var(--error); border-radius: 12px; padding: 12px 16px; margin-bottom: 16px; font-size: 14px; }
        .errors ul { margin: 0; padding-left: 18px; }
        .hidden { display: none; }
    </style>
</head>
<body>
@php
    $startStep2 = $errors->hasAny(['service_type','bedrooms','bathrooms','zip_code','preferred_date','consent'])
        && ! $errors->hasAny(['first_name','last_name','phone','email']);
@endphp

<main class="card">
    <p class="logo">SparkleNest ✨</p>
    <h1>Get Your Free Quote</h1>
    <p class="sub">A cleaner home is just 60 seconds away.</p>
    <p class="sub" style="font-size:13px;">Demo form for portfolio purposes. Please don't enter real personal information.</p>

    <div class="progress">
        <div id="p1" class="{{ $startStep2 ? '' : 'active' }}">1 Your details</div>
        <div id="p2" class="{{ $startStep2 ? 'active' : '' }}">2 Home details</div>
    </div>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="quoteForm" method="POST" action="{{ route('quote.store') }}">
        @csrf

        {{-- Honeypot (hidden from humans) --}}
        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">

        {{-- STEP 1 --}}
        <section id="step1" class="{{ $startStep2 ? 'hidden' : '' }}">
            <div class="row">
                <label>First Name
                    <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name') }}" required>
                </label>
                <label>Last Name
                    <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}" required>
                </label>
            </div>
            <label>Phone
                <input type="tel" name="phone" placeholder="(512) XXX-XXXX" value="{{ old('phone') }}" required>
            </label>
            <label>Email
                <input type="email" name="email" placeholder="you@email.com" value="{{ old('email') }}" required>
            </label>
            <button type="button" id="nextBtn" class="btn">Continue to Home Details →</button>
            <p class="micro">No spam. No commitment. Reply within 15 minutes (8am to 8pm).</p>
        </section>

        {{-- STEP 2 --}}
        <section id="step2" class="{{ $startStep2 ? '' : 'hidden' }}">
            <label>Service Type
                <select name="service_type" required>
                    <option value="">Select...</option>
                    @foreach (['Standard Clean', 'Deep Clean', 'Move-In/Move-Out'] as $s)
                        <option value="{{ $s }}" @selected(old('service_type') === $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </label>

            <div class="row">
                <label>Bedrooms
                    <select name="bedrooms" required>
                        <option value="">Select...</option>
                        @foreach (['1','2','3','4','5+'] as $b)
                            <option value="{{ $b }}" @selected(old('bedrooms') === $b)>{{ $b }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Bathrooms
                    <select name="bathrooms" required>
                        <option value="">Select...</option>
                        @foreach (['1','2','3','4+'] as $b)
                            <option value="{{ $b }}" @selected(old('bathrooms') === $b)>{{ $b }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="row">
                <label>ZIP Code
                    <input type="text" name="zip_code" placeholder="e.g. 78701" inputmode="numeric" maxlength="5" value="{{ old('zip_code') }}" required>
                </label>
                <label>Preferred Date
                    <input type="date" name="preferred_date" min="{{ now()->toDateString() }}" value="{{ old('preferred_date') }}" required>
                </label>
            </div>

            <label class="consent">
                <input type="checkbox" name="consent" value="1" required>
                <span>I agree to receive text messages and emails from SparkleNest Home Cleaning about my quote and booking. Msg &amp; data rates may apply. Reply STOP to opt out.</span>
            </label>

            <button type="submit" id="submitBtn" class="btn">Get My Free Quote</button>
            <button type="button" id="backBtn" class="btn-link">← Back</button>
        </section>
    </form>
</main>

<script>
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const p1 = document.getElementById('p1');
    const p2 = document.getElementById('p2');
    const form = document.getElementById('quoteForm');

    function showStep(n) {
        step1.classList.toggle('hidden', n !== 1);
        step2.classList.toggle('hidden', n !== 2);
        p1.classList.toggle('active', n === 1);
        p2.classList.toggle('active', n === 2);
    }

    document.getElementById('nextBtn').addEventListener('click', () => {
        // Only continue if the step 1 fields are valid
        const fields = step1.querySelectorAll('input[required]');
        for (const f of fields) {
            if (!f.reportValidity()) return;
        }
        showStep(2);
    });

    document.getElementById('backBtn').addEventListener('click', () => showStep(1));

    form.addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.textContent = 'Sending...';
    });
</script>
</body>
</html>