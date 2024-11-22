<?php

use App\Livewire\Cadastro;
use App\Livewire\Historico;
use App\Livewire\TranscreverLink;
use App\Livewire\Login;
use App\Livewire\TranscreverAudio;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/transcrever-link', TranscreverLink::class)->name('transcrever-link');
    Route::get('/transcrever-audio', TranscreverAudio::class)->name('transcrever-audio');
    Route::get('/', function () {
        return redirect()->route('transcrever-link');
    })->name('home');
    Route::get('historico/{id}', Historico::class)->name('historico');
});

Route::get('/cadastro', Cadastro::class)->name('cadastro');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');
