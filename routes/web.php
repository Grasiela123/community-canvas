<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('home');
});

Route::controller(UserController::class)->group(function() {
    Route::get('/register', 'register');
    Route::post('/register', 'create');
    Route::get('/edit-profile', 'profile');
    Route::put('/edit-profile/{id}', 'update')->name('profile.update');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginpage');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
});

Route::controller(FeedController::class)->group(function () {
    Route::get('/feed', 'getFeed')->name('view.feed');
});

Route::controller(EventController::class)->group(function () {
    Route::get('/calendar', 'viewCalendar');
    Route::post('/calendar', 'getEventsByDate')->name('events.by.date');
    Route::get('/create-event', 'viewCreateEvent');
    Route::post('/create-event', 'store');
    Route::get('/update-event/{event}', 'findById')->name('view.event.update');
    Route::put('/update-event/{event}', 'update')->name('event.update');
});

Route::controller(NewsController::class)->group(function () {
    Route::get('/create-news', 'index')->name('view.news.create');
    Route::post('/create-news', 'store')->name('news.create');
    Route::get('/update-news/{news}', 'findById')->name('view.news.update');
    Route::put('/update-news/{news}', 'update')->name('news.update');
});

Route::controller(PollController::class)->group(function () {
    Route::get('/create-poll', 'index')->name('view.poll.create');
    Route::post('/create-poll', 'store')->name('poll.create');
    Route::post('/feed/{pollId}', 'vote')->name('poll.vote');
    Route::get('/update-poll/{poll}', 'findById')->name('view.poll.update');
    Route::put('/update-poll/{poll}', 'update')->name('poll.update');
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('view.profile');
    Route::delete('/profile/{type}/{id}', 'delete')->name('delete.item');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->name('view.admin');
    Route::delete('/admin/{type}/{id}', 'delete')->name('admin.delete');
    Route::get('/update-user/{id}', 'getUserById')->name('view.update.user');
    Route::put('/update-user/{id}', 'update')->name('update.user');
    Route::get('/update-news-admin/{news}', 'getNewsById')->name('view.news.update.admin');
    Route::put('/update-news-admin/{news}', 'updateNews')->name('news.update.admin');
    Route::get('/update-poll-admin/{poll}', 'getPollById')->name('view.poll.update.admin');
    Route::put('/update-poll-admin/{poll}', 'updatePoll')->name('poll.update.admin');
    Route::get('/update-event-admin/{event}', 'getEventById')->name('view.event.update.admin');
    Route::put('/update-event-admin/{event}', 'updateEvent')->name('event.update.admin');
});



