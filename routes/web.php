<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
//tes email dengan smtp gmail
//Route::get('/kirim-email', [EmailController::class, 'index']);
// reset password
Route::name('reset.')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('index');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'postEmail'])->name('email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'getPassword'])->name('password');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('update.password');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'loginPage'])->name('login.page');
Route::get('/registrasi', [HomeController::class, 'registrasiPage'])->name('registrasi.page');
Route::post('/login', [HomeController::class, 'login'])->name('login');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/akun', [HomeController::class, 'akun'])->name('akun');
Route::get('/petunjuk', [HomeController::class, 'petunjuk'])->name('petunjuk');
// login socialite
Route::get('oauth/{driver}', [HomeController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [HomeController::class, 'handleProviderCallback'])->name('social.callback');
//Route::get('oauth/google', [HomeController::class, 'redirectToGoogle'])->name('login.google');
//Route::get('oauth/google/callback', [HomeController::class, 'handleGoogleCallback']);

Route::name('user.')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('index');
    Route::get('/user/dt', [UserController::class, 'dt'])->name('dt');
    Route::get('/user/show/{id?}', [UserController::class, 'show'])->name('show');
    Route::post('/user/store', [UserController::class, 'store'])->name('store');
    Route::post('/user/update/{id?}', [UserController::class, 'update'])->name('update')->middleware('auth');
    Route::get('/user/destroy/{id?}', [UserController::class, 'destroy'])->name('destroy')->middleware('auth');
    Route::get('/user/chart', [UserController::class, 'chart'])->name('chart');
});

Route::name('bank.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/bank', [BankController::class, 'index'])->name('index');
    Route::post('/bank/dt', [BankController::class, 'dt'])->name('dt');
    Route::get('/bank/create', [BankController::class, 'create'])->name('create');
    Route::post('/bank/store', [BankController::class, 'store'])->name('store');
    Route::get('/bank/destroy/{id?}', [BankController::class, 'destroy'])->name('destroy');
    Route::get('/bank/show/{id?}', [BankController::class, 'show'])->name('show');
    Route::post('/bank/update/{id?}', [BankController::class, 'update'])->name('update');
    Route::post('/bank/masuk', [BankController::class, 'masuk'])->name('masuk');
    Route::post('/bank/keluar', [BankController::class, 'keluar'])->name('keluar');
    Route::get('/bank/chart', [BankController::class, 'chart'])->name('dt');
    Route::get('bank/option', [BankController::class, 'option'])->name('option');
    Route::get('pemasukan/create', [BankController::class, 'createPemasukan'])->name('create.pemasukan');
    Route::get('pengeluaran/create', [BankController::class, 'createPengeluaran'])->name('create.pengeluaran');
});

Route::name('anggaran.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('index');
    Route::post('/anggaran/dt', [AnggaranController::class, 'dt'])->name('dt');
    Route::post('/anggaran/store', [AnggaranController::class, 'store'])->name('store');
    Route::get('/anggaran/destroy/{id?}', [AnggaranController::class, 'destroy'])->name('destroy');
    Route::get('/anggaran/show/{id?}', [AnggaranController::class, 'show'])->name('show');
    Route::post('/anggaran/update/{id?}', [AnggaranController::class, 'update'])->name('update');
    Route::get('anggaran/option', [AnggaranController::class, 'option'])->name('option');
});

Route::name('history.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/history/chart', [HistoryController::class, 'chart'])->name('chart');
    Route::get('/history', [HistoryController::class, 'index'])->name('index');
    Route::post('/history/dt', [HistoryController::class, 'dt'])->name('dt');
    Route::get('/laporan', [HistoryController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/download', [HistoryController::class, 'download'])->name('download');
    Route::get('/history/restore/{id?}', [HistoryController::class, 'restore'])->name('restore');
});

Route::name('bantuan.')->middleware('auth')->group(function () {
    Route::get('/bantuan', [BantuanController::class, 'index'])->name('index');
    Route::get('/bantuan/dt', [BantuanController::class, 'dt'])->name('dt');
    Route::post('/bantuan/store', [BantuanController::class, 'store'])->name('store');
    Route::get('/bantuan/destroy/{id?}', [BantuanController::class, 'destroy'])->name('destroy');
    Route::get('/bantuan/show/{id?}', [BantuanController::class, 'show'])->name('show');
    Route::post('/bantuan/update/{id?}', [BantuanController::class, 'update'])->name('update');
});

Route::name('feedback.')->middleware('auth')->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('index');
    Route::get('/feedback/dt', [FeedbackController::class, 'dt'])->name('dt');
    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('store');
    Route::get('/feedback/destroy/{id?}', [FeedbackController::class, 'destroy'])->name('destroy');
    Route::get('/feedback/show/{id?}', [FeedbackController::class, 'show'])->name('show');
    Route::post('/feedback/update/{id?}', [FeedbackController::class, 'update'])->name('update');
});

Route::name('tanggapan.')->middleware('auth')->group(function () {
    Route::post('tanggapan/store', [TanggapanController::class, 'store'])->name('store');
    Route::get('tanggapan/show/{id?}', [TanggapanController::class, 'show'])->name('show');
    Route::post('tanggapan/update/{id?}', [TanggapanController::class, 'update'])->name('update');
    Route::get('tanggapan/destroy/{id?}', [TanggapanController::class, 'destroy'])->name('destroy');
});

Route::name('plan.')->middleware(['auth', 'user'])->group(function () {
    Route::get('plan', [PlanController::class, 'index'])->name('index');
    Route::get('plan/create', [PlanController::class, 'create'])->name('create');
    Route::post('plan/store', [PlanController::class, 'store'])->name('store');
    Route::post('plan/update/{id?}', [PlanController::class, 'update'])->name('update');
    Route::get('plan/destroy/{id?}', [PlanController::class, 'destroy'])->name('destroy');
});
//Route::resource('plan', PlanController::class)->middleware(['auth', 'user']);