<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\Peminjam\PeminjamBookController;
use App\Http\Controllers\Peminjam\PeminjamBorrowingController;
use App\Http\Controllers\Peminjam\PeminjamDashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('peminjam.dashboard');
        }
    }
    return redirect()->route('login');
});
//middleware untuk guest blm login
Route::middleware(['guest'])->group(function () {
    Route::get('auth/login',[authController::class,'showLoginForm'])->name('login');
    Route::post('auth/login',[authController::class,'loginProcess'] )->name('loginProcess');
});
//untuk yang sudah login
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function(){
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Route Kustom untuk Pengembalian Buku
  Route::put('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

  Route::resource('books', BookController::class);
  Route::resource('borrowings', BorrowingController::class);
  // Route untuk manajemen user
  Route::resource('user', UserController::class);
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('user')->middleware(['auth'])->name('peminjam.')->group(function(){
Route::resource('books',PeminjamBookController::class);
Route::resource('borrowings',PeminjamBorrowingController::class);
Route::get('dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');
 Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
//dashboard peminjam
// peminjaman buku
// daftar buku 
// pengembalian buku

