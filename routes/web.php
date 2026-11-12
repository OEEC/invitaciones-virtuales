<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicInvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('admin.invitations'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::livewire('/invitaciones', 'invitations.index')->name('admin.invitations');
    Route::livewire('/invitaciones/{invitation}', 'invitations.edit')->name('admin.invitations.edit');
    Route::livewire('/invitaciones/{invitation}/invitados', 'invitations.guests')->name('admin.invitations.guests');
});

Route::post('/i/{slug}/{token}/rsvp', [PublicInvitationController::class, 'rsvp'])->name('invitation.rsvp');
Route::get('/i/{slug}/{token?}', [PublicInvitationController::class, 'show'])->name('invitation.show');