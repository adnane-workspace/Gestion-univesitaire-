<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | EduPortal UPF</title>
    <meta name="description" content="Accédez à votre espace EduPortal à l'Université Panafricaine.">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Geist', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .anim-slide-up { animation: slideUp 0.5s ease-out both; }
    </style>
</head>

<body class="h-full flex items-center justify-center p-5 relative overflow-hidden">

    {{-- Background decorations --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-indigo-100 rounded-full blur-[100px] opacity-50"></div>
        <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] bg-violet-100 rounded-full blur-[100px] opacity-50"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-50 rounded-full blur-[120px] opacity-30"></div>
        {{-- Subtle grid pattern --}}
        <div class="absolute inset-0 opacity-[0.015]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 40V0h40' fill='none' stroke='%23000' stroke-width='1'/%3E%3C/svg%3E&quot;);"></div>
    </div>

    {{-- Back to home button (moved inside card to avoid overlapping inputs) --}}

    <div class="w-full max-w-[420px] anim-slide-up">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-xl shadow-indigo-200/50">
                    <span class="text-white font-black text-xl">U</span>
                </div>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">EduPortal</h1>
            <p class="text-sm text-slate-400 font-medium mt-1">@yield('subtitle')</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 p-7 relative overflow-hidden anim-slide-up" style="animation-delay: 0.1s">
            

            {{-- Top accent line --}}
            <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 via-violet-500 to-indigo-600"></div>

            @yield('content')
        </div>

        {{-- Footer --}}
        <p class="text-center mt-6 text-[11px] font-bold text-slate-300 uppercase tracking-[0.15em]">
            &copy; {{ date('Y') }} EduPortal UPF
        </p>
    </div>
</body>

</html>
