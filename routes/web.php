<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/certificate/download/{course}/{student}',
    [CertificateController::class, 'download']
)->name('certificate.download');