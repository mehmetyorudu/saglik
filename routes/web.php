<?php

use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDietMealController;
use App\Http\Controllers\Admin\AdminDietPlanController;
use App\Http\Controllers\Admin\AdminForumController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminTestController;
use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\DietController;
use App\Http\Controllers\User\FileUploadController;
use App\Http\Controllers\User\ForumController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserTestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DoctorAppointmentController;
use App\Http\Controllers\Doctor\DoctorArticleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login Sayfası
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

//Login Sonrası anasayfa
Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth')->name('dashboard');


### Kullanıcı Rotaları

Route::middleware('auth')->group(function () {

    // Profil Düzenleme ve Kalori Rotaları
    Route::get('/profile/edit-user-info', [ProfileController::class, 'editUser'])->name('profile.edit.user');
    Route::get('/profile/edit-health-info', [ProfileController::class, 'editHealth'])->name('profile.edit.health');
    Route::put('/profile/update-user-info', [ProfileController::class, 'updateUser'])->name('profile.update.user');
    Route::put('/profile/update-health-info', [ProfileController::class, 'updateHealth'])->name('profile.update.health');
    Route::post('/calculate-calories', [ProfileController::class, 'calculateCalories'])->name('calculate.calories');

    // Forum Rotaları
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{forumPost}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/{forumPost}/comments', [ForumController::class, 'storeComment'])->name('forum.comments.store');

    // Diyet Rotaları
    Route::get('diet', [DietController::class, 'index'])->name('diet.index');
    Route::get('diet/{dietPlan}', [DietController::class, 'show'])->name('diet.show');

    // Test Rotaları
    Route::get('/tests', [UserTestController::class, 'index'])->name('tests.index');
    Route::get('/tests/{test}/take', [UserTestController::class, 'take'])->name('tests.take');
    Route::post('/tests/{test}/submit', [UserTestController::class, 'submit'])->name('tests.submit');
    Route::get('/my-test-results', [UserTestController::class, 'myResults'])->name('user.my_test_results');
    Route::get('/my-test-results/{attempt}', [UserTestController::class, 'showAttemptDetail'])->name('user.test_attempt_detail');

    // Market Rotaları
    Route::get('/market', [ProductController::class, 'index'])->name('market.index');
    Route::get('/market/{product}', [ProductController::class, 'show'])->name('market.show');

    // Randevu Rotaları
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/api/appointments/booked_slots', [AppointmentController::class, 'getBookedSlots'])->name('appointments.booked_slots');

});


###Herkesin Görebildiği Rotalar

// Makale Rotaları (Herkes Görüntüleyebilir)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');


### Admin Rotaları

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Kullanıcı Listesi
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit'); // Düzenleme Formu
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update'); // Formu Gönderme

    // Admin Randevu Rotaları
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{appointment}/approve', [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::delete('/appointments/{appointment}/reject', [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::put('/appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
    Route::put('/appointments/{appointment}/incomplete', [AdminAppointmentController::class, 'incomplete'])->name('appointments.incomplete');

    // Admin Forum Rotaları

    Route::get('/forum', [AdminForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/{id}', [AdminForumController::class, 'show'])->name('forum.show');
    Route::get('/forum/{id}/edit', [AdminForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{id}', [AdminForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{id}', [AdminForumController::class, 'destroyPost'])->name('forum.destroy');
    Route::delete('/comments/{id}', [AdminForumController::class, 'destroyComment'])->name('comments.destroy');

    // Admin Diyet Rotaları
    Route::resource('diet-plans', AdminDietPlanController::class);
    Route::delete('diet-plans/{dietPlan}/diet-meals/bulk-destroy', [AdminDietMealController::class, 'bulkDestroy'])->name('diet-plans.diet-meals.bulk-destroy');
    Route::get('diet-plans/{dietPlan}/diet-meals', [AdminDietMealController::class, 'editWeek'])->name('diet-plans.diet-meals.edit-week');
    Route::get('diet-plans/{dietPlan}/diet-meals/create-week', [AdminDietMealController::class, 'createWeek'])->name('diet-plans.diet-meals.create-week');
    Route::put('diet-plans/{dietPlan}/diet-meals/update-week', [AdminDietMealController::class, 'updateWeek'])->name('diet-plans.diet-meals.update-week');
    Route::delete('diet-plans/{dietPlan}/diet-meals/{dietMeal}', [AdminDietMealController::class, 'destroy'])->name('diet-plans.diet-meals.destroy');

    // Admin Makale Rotaları
    Route::resource('articles', AdminArticleController::class);
    Route::post('/articles/upload-file', [FileUploadController::class, 'uploadArticleFile'])->name('articles.upload_file');

    // Admin Test Rotaları
    Route::resource('tests', AdminTestController::class)->names('tests');
    Route::get('tests/{test}/questions/create', [AdminTestController::class, 'createQuestion'])->name('tests.questions.create');
    Route::post('tests/{test}/questions', [AdminTestController::class, 'storeQuestion'])->name('tests.questions.store');
    Route::get('tests/{test}/questions/{question}/edit', [AdminTestController::class, 'editQuestion'])->name('tests.questions.edit');
    Route::put('tests/{test}/questions/{question}', [AdminTestController::class, 'updateQuestion'])->name('tests.questions.update');
    Route::delete('tests/{test}/questions/{question}', [AdminTestController::class, 'destroyQuestion'])->name('tests.questions.destroy');
    Route::get('tests/{test}/results', [AdminTestController::class, 'viewResults'])->name('tests.results');
    Route::get('test-attempts/{attempt}', [AdminTestController::class, 'showAttemptDetail'])->name('tests.attempt_detail');
    Route::delete('tests/attempts/{attempt}', [AdminTestController::class, 'destroyAttempt'])->name('tests.attempt_delete');

    // Admin Ürün Rotaları
    Route::delete('products/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::resource('products', AdminProductController::class)->names('products');

});

### Doktorların Görebildiği Rotalar

Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {


        //Makale rotaları
        Route::get('articles', [DoctorArticleController::class, 'index'])->name('articles.index');
        Route::get('articles/create', [DoctorArticleController::class, 'create'])->name('articles.create');
        Route::post('articles', [DoctorArticleController::class, 'store'])->name('articles.store');
        Route::get('articles/{article}/edit', [DoctorArticleController::class, 'edit'])->name('articles.edit');
        Route::put('articles/{article}', [DoctorArticleController::class, 'update'])->name('articles.update');
        Route::delete('articles/{article}', [DoctorArticleController::class, 'destroy'])->name('articles.destroy');


        //Randevu rotaları
        Route::get('appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
        Route::put('appointments/{appointment}/approve', [DoctorAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::delete('appointments/{appointment}/reject', [DoctorAppointmentController::class, 'reject'])->name('appointments.reject');
        Route::put('appointments/{appointment}/complete', [DoctorAppointmentController::class, 'complete'])->name('appointments.complete');
        Route::put('appointments/{appointment}/incomplete', [DoctorAppointmentController::class, 'incomplete'])->name('appointments.incomplete');


        // Diet rotaları
        Route::get('diets', [DoctorDietController::class, 'index'])->name('diets.index');
        Route::post('diets', [DoctorDietController::class, 'store'])->name('diets.store');
        Route::get('diets/{diet}/edit', [DoctorDietController::class, 'edit'])->name('diets.edit');
        Route::put('diets/{diet}', [DoctorDietController::class, 'update'])->name('diets.update');
        Route::delete('diets/{diet}', [DoctorDietController::class, 'destroy'])->name('diets.destroy');
    });

