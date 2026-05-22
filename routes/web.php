<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\TeacherController;

// Route::get('/', function () {
//     return view('welcome');
// })->name("root");



// Task 1 : Creating Named Routes
// Route::get('/home' , function() { 
//     return "I am Nick VIncent Agbuya. Welcome to Home Page!";
// })->name("home.page");

// Task 2: using Named Routes
Route::get('/redirect-home', function(){
    return redirect() ->route("home.page");
})->name("redirect");


// Task 3 : Required Route Parameter
Route::get('/greet/{name}' , function ($name = "User") {
    return "Hello {$name}";
})->name("greet");

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/password/change', [PasswordChangeController::class, 'show'])->name('password.change');
    Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/maintenance-manager', [MaintenanceController::class, 'index'])->name('maintenance-manager.index');
        Route::post('/maintenance-manager', [MaintenanceController::class, 'update'])->name('maintenance-manager.update');

        Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
        Route::get('/students/export/pdf', [StudentController::class, 'exportPdf'])->name('students.export.pdf');
        Route::resource('/students', StudentController::class);

        Route::get('/teacher/export', [TeacherController::class, 'export'])->name('teacher.export');
        Route::get('/teacher/export/pdf', [TeacherController::class, 'exportPdf'])->name('teacher.export.pdf');
        Route::resource('/degrees', DegreeController::class)->except(['show']);
        Route::resource('/users', UserController::class);
        Route::resource('/course_students', CourseStudentController::class);
        Route::resource('/teacher', TeacherController::class);
        Route::resource('/profiles', ProfileController::class)->only(['index', 'show', 'edit', 'update']);
    });

    // Admin & Teacher routes
    Route::middleware(['role:admin,teacher'])->group(function () {
        Route::resource('/posts', PostController::class)->except(['index', 'show']);
        Route::get('/teacher-dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/teacher/course/{course}/students', [TeacherController::class, 'courseStudents'])->name('teacher.course.students');
        Route::post('/teacher/course/{course}/students/grade', [TeacherController::class, 'submitGrades'])->name('teacher.course.grade');
    });

    // Common authenticated routes
    Route::resource('/posts', PostController::class)->only(['index', 'show']);
    Route::resource('/courses', CourseController::class);
    Route::get('/clientProfile', [ProfileController::class, 'clientProfile'])->name('clientProfile');
    Route::get('/clientDashboard', [ClientController::class, 'clientDashboard'])->name('clientDashboard');
    Route::get('/clientAboutUs', [ClientController::class, 'clientAboutUs'])->name('clientAboutUs');
});


Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        if (Auth::user()->role === 'student') {
            return redirect()->route('clientDashboard');
        }
        if (Auth::user()->role === 'admin') {
            // Keep home or redirect to admin dashboard if exists
            return view('homepage');
        }
    }
    return view('homepage');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Task 4: Optional Parameter
Route::get('/student/{name?}' , function ($name = "Student") {
    return "Hello, {$name}!";
})->name("student");

// Task 5 : Route group with prefix
Route::prefix('/administrator')->group(
    function(){
        Route::get('/dashboard', function () {
            return "Dashboard";
        })->name("dashboard");
        Route::get('/profile', function () {
            return "Welcome to Profile";
        });
        Route::get('/settings', function () {
            return "Settings Page";
        });   
    }
);
// Task 6 :
Route::get('/redirectAdminDashboard' , function(){
    return redirect() ->route("dashboard");
});






Route::get('/user_profiles', [PagesController::class, 'user_profiles'])->name('user_profiles');
Route::get('/student_course', [PagesController::class, 'student_course'])->name('student_course');


// ABOUT
Route::get('/sum' , [CalculateController::class,'sum'])->name("add");
Route::get('/subtract' , [CalculateController::class,'subtract'])->name("subtract");
Route::get('/multiply' , [CalculateController::class,'multiply'])->name("multiply");
Route::get('/divide' , [CalculateController::class,'divide'])->name("divide");
Route::get('/modulo' , [CalculateController::class,'reminder'])->name("modulo");

Route::get('/psu/welcome', [PSUController::class, 'welcome'])->name('welcome');
Route::get('/psu/mission', [PSUController::class, 'mission'])->name('mission');
Route::get('/psu/vision', [PSUController::class, 'vision'])->name('vision');
Route::get('/psu/eoms-policy', [PSUController::class, 'EOMSPolicy'])->name('eoms-policy');
Route::get('/psu/student/{name}/{course}', [PSUController::class, 'student'])->name('psu.student');

Route::resource('/clients', PSUController::class);



Route::get('/vincent', function () {
    return view('vincent');
})->name("vincent");

// Route::get('/maricar', function () {
//     return view('maricar');
// })->name("maricar");


// Route::get('/greet/{fname}/posts/msg' , function ($fname = "User", $msg = "Hel1lo World")  {
//     return "Welcome, {$fname} to Laravel Application Development {$msg} !";
// });

// Route::get('/search/{id}', function ($id)  {
//     return "ID  = {$id}" ;
// })->name("id")->where("id", "[0-9]+");






// Route::prefix('/admin')->group(
//     function(){
//         Route::get('/dashboard', function () {
//             return "This is the dashboard of admin";
//         });
//         Route::get('/profile', function () {
//             return "This is the profile of admin";
//         });
//         Route::get('/config', function () {
//             return "This is the configuration of admin";
//         });   
//     }
// );




Route::resource('/mainlayout', StudentController::class);









Route::get('/profile1', function () {
    return "<h1>Student Profile 1</h1><hr><strong>TOPIC:</strong> Routing<br><strong>ACTIVITY:</strong> 1<br><br><strong>STUDENT NAME:</strong><br>Resquid Virgienica<br><br><strong>STUDENT ADDRESS:</strong><br>San Carlos City, Pangasinan<br><br><strong>STUDENT COURSE:</strong><br>Bachelor of Science in Information Technology<br><br><strong>SCHOOL:</strong><br>Binalatongan Community College<br><hr>";
})->name('profile1');

Route::get('/profile2', function () {
    return "<h1>Student Profile 2</h1><hr><strong>TOPIC:</strong> Routing<br><strong>ACTIVITY:</strong> 1<br><br><strong>STUDENT NAME:</strong><br>Resquid Virgienica<br><br><strong>STUDENT ADDRESS:</strong><br>San Carlos City, Pangasinan<br><br><strong>STUDENT COURSE:</strong><br>Bachelor of Science in Information Technology<br><br><strong>SCHOOL:</strong><br>Binalatongan Community College<br><hr>";
})->name('profile2');

//ACTIVITY 1
Route::get('/redirect-method-1', function () {
    return redirect()->route('profile1');
})->name('redirect-method1');

Route::get('/redirect-method-2', function () {
    return redirect()->to('/profile2');
})->name('redirect-method2');


// ACTIVITY 2
//PART 1
Route::get('/profile/{studentName}/{id}/{address}' ,  function($studentName, $id, $address){
    return "<h1>Required Parameters</h1><hr><strong>ACTIVITY:</strong> 2<br><strong>PART:</strong> 1<br><strong>PARAMETERS:</strong> Required<br><br><strong>NAME:</strong><br>{$studentName}<br><br><strong>ID:</strong><br>{$id}<br><br><strong>STUDENT ADDRESS:</strong><br>{$address}<br><hr>";
})->name('required');

//PART 2
Route::get('/profile/{studentName?}/{id?}/{address?}' ,  function($studentName = "Resquid Virgienica", $id = "023-721", $address = "Brgy,Cacaritan San Carlos City Pangasina"){ 
    return "<h1>Optional Parameters</h1><hr><strong>ACTIVITY:</strong> 2<br><strong>PART:</strong> 2<br><strong>PARAMETERS:</strong> Optional<br><br><strong>NAME:</strong><br>{$studentName}<br><br><strong>ID:</strong><br>{$id}<br><br><strong>STUDENT ADDRESS:</strong><br>{$address}<br><hr>";
})->name('optional');

































// #Required
// Route::get('/users/{id}/posts/{name}', function ($id, $name) {
//     return "User ID: {$id}, Post Name: {$name}";
// })->name('user.posts');
// #Optionals
// Route::get('/products/{category?}', function ($category = 'all') {
//     return "Product Category: {$category}";
// })->name('products.list');





