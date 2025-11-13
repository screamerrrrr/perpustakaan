<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Perpustakaan</title>
  <!-- Load Tailwind CSS dari CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body>
  <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-xl overflow-hidden">
      <!-- Header -->
      <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-center">
        <h2 class="text-3xl font-bold text-white">
          <i class="fas fa-book-open mr-2"></i> PerpustakaanKu
        </h2>
        <p class="mt-2 text-blue-100">Silakan masuk untuk melanjutkan</p>
      </div>

      <!-- Form -->
      <div class="p-8">
        <form class="mt-4 space-y-6" method="POST" action="{{ route('loginProcess') }}">
          @csrf
          <input type="hidden" name="remember" value="true">

          <div class="rounded-md shadow-sm -space-y-px">
            <div>
              <label for="email" class="sr-only">Email</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input id="email" name="email" type="email" autocomplete="email" required class="pl-10 appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Email">
              </div>
            </div>
            <div class="mt-4">
              <label for="password" class="sr-only">Password</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input id="password" name="password" type="password" autocomplete="current-password" required class="pl-10 appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Password">
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                Ingat saya
              </label>
            </div>
            <div class="text-sm">
              <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                Lupa password?
              </a>
            </div>
          </div>

          <div>
            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              Masuk
            </button>
          </div>
        </form>
      </div>

      <!-- Footer -->
      <div class="bg-gray-50 py-4 px-6 text-center text-sm text-gray-600">
        © {{ date('Y') }} PerpustakaanKu. Hak Cipta Dilindungi.
      </div>
    </div>
  </div>
</body>
</html>