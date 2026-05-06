<!DOCTYPE html>
<html lang="fr" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduPortal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Geist', sans-serif;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="h-full flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full -z-10 overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-100 rounded-full blur-[120px] opacity-60">
        </div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-100 rounded-full blur-[120px] opacity-60">
        </div>
    </div>

    <div class="w-full max-w-md relative">
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center mb-6 group hover:scale-110 transition-transform duration-500">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-40 h-40 object-contain">
            </div>
            <p class="text-slate-500 mt-3 font-medium">@yield('subtitle')</p>
        </div>

        <div
            class="bg-white p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden">
            <!-- Decorative line -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            </div>

            @yield('content')
        </div>

        <p class="text-center mt-10 text-xs font-bold text-slate-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} EduPortal Academic System
        </p>
    </div>
</body>

</html>