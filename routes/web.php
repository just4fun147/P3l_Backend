<?php

use App\Mail\Receipt;
use App\Mail\Invoice;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-mail', function (){
    $name = 'abc';
    $noRev = '123456';
    $body = [
        'name' => $name,
        'url' => 'urlnya' ,
        'sm' =>'https://wa.me/6281226775044?text=Halo,%20saya%20ingin%20konfirmasi%20untuk%20pemesanan%20dengan%20nomor%20reservasi:%20'.$noRev.'%20atas%20nama'.$name,
        'date' => '20/10/2023' ,
        'due_date' => '30/10/2023' ,
    ];
    Mail::to('pauluswindito1@gmail.com')->send(new Receipt($body));
    return 'Sent';
});
Route::get('/test-mail-invoice', function (){
    $name = 'abc';
    $noRev = '123456';
    $body = [
        'name' => $name,
        'url' => 'urlnya' ,
    ];
    Mail::to('pauluswindito1@gmail.com')->send(new Invoice($body));
    return 'Sent';
});
