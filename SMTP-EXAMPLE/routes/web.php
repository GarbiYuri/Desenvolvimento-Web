<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleEmail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/MailSended', function () {
    return view('MailSended');
});
Route::get('/Enviar-Mail', function () {
    Mail::to('gorida2543@ovobri.com')->send(new ExampleEmail());
});
