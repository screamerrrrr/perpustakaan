<!DOCTYPE html>
<html lang="id" class="dark:bg-gray-900 bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard | PerpustakaanKu' }}</title>
    <!-- Load Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dark body {
            background-color: #1a202c;
        }
        .sidebar {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        .dark .sidebar {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }
        .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .dark .sidebar a:hover {
            background-color: rgba(255,255,255,0.15);
        }
        .card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="flex h-screen dark:bg-gray-900">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        @include('partials.header')

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 dark:bg-gray-800">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    <script>
        // Toggle dark mode
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('color-theme', 'dark');
            } else {
                localStorage.setItem('color-theme', 'light');
            }
        }
    </script>
</body>
</html>