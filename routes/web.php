<?php

use App\Events\LiveSupport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AffiliateAuthController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\FreeCourseController;


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/success-story',[HomeController::class,'successStory'])->name('success-Story');
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/all/courses',[HomeController::class,'allCourse'])->name('allCourse');
Route::get('/course/{title}/{id}',[UserCourseController::class,'course'])->name('course');
Route::get('/blogs',[UserBlogController::class,'blogs'])->name('user.blogs');
Route::get('/blogs/{title}/{id}',[UserBlogController::class,'blogsPage'])->name('blogsPage');
Route::get('/contact',[UserBlogController::class,'contact'])->name('user.contact');
Route::post('/contact-submit', [UserBlogController::class, 'submit'])->name('contact.submit');
Route::post('/free-course/check-email', [FreeCourseController::class, 'checkEmail'])->name('free-course.check-email');
Route::post('/free-course/verify-code', [FreeCourseController::class, 'verifyCode'])->name('free-course.verify-code');

Route::group(['prefix' => 'account'],function(){
    Route::group(['middleware' => 'guest'],function(){

        Route::post('/user/login', [UserAuthController::class,'signin'])->name('user.login');
        Route::get('/signin',[UserAuthController::class,'login'])->name('login');
        Route::get('/register',[UserAuthController::class,'register'])->name('register');
        Route::get('/forget/password',[UserAuthController::class,'forgetPass'])->name('forgetPass');
        Route::post('/signin', [UserAuthController::class, 'signin'])->name('signin');
        Route::post('/signUp', [UserAuthController::class, 'signUp'])->name('userRegister');
        Route::post('/send-verification-code', [UserAuthController::class, 'sendVerificationCode'])->name('sendVerificationCode');
        Route::post('/verify-code', [UserAuthController::class, 'verifyCode'])->name('verifyCode');
        Route::post('/affiliate-register', [AffiliateAuthController::class, 'affiliateRegister'])->name('affiliateRegister');
        Route::post('/affi-verify-code', [AffiliateAuthController::class, 'verifyCode'])->name('affiverifyCode');
        Route::post('/password/email', [UserAuthController::class, 'sendResetCode'])->name('password.email');
        Route::post('/password/verify-code', [UserAuthController::class, 'resetVerifyCode'])->name('password.verifyCode');
        Route::post('/password/reset', [UserAuthController::class, 'resetPassword'])->name('password.reset');
    });

    Route::group(['middleware' => 'auth'],function(){
        Route::get('/user/logout',[UserAuthController::class,'logout'])->name('user.logout');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart/count', [CartController::class, 'cartCount'])->name('cart.count');
        Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
        Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
        Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/cart', [CartController::class, 'cartPage'])->name('cart.page');
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::get('/user/dashboard', [UserDashboardController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/user/orders', [UserDashboardController::class, 'userorders'])->name('user.orders');
        Route::get('/user/orders', [UserDashboardController::class, 'userorders'])->name('user.orders');
        Route::get('/user/profile', [UserDashboardController::class, 'userprofile'])->name('user.profile');
        Route::get('/user/change/Password', [UserDashboardController::class, 'userchangePass'])->name('user.changePass');
        Route::get('/user/courseEnroll/{title}/{id}', [UserDashboardController::class, 'courseEnroll'])->name('user.courseEnroll');
        Route::get('/account/video/stream/{randomPath}', [VideoController::class, 'stream'])->name('video.stream');
        Route::post('/update-userprofile', [UserDashboardController::class, 'updateUserProfile'])->name('update-userprofile');
        Route::post('/verify-email-code', [UserDashboardController::class, 'verifyEmailCode'])->name('verify-email-code');
        Route::post('/update-password', [UserDashboardController::class, 'updatePassword'])->name('update-password');
        Route::post('/send-payment-request/{user}', [UserDashboardController::class, 'sendPaymentRequest'])->name('send.payment.request');

    });
});

Route::group(['prefix' => 'admin'],function(){

    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[DashboardController::class,'logout'])->name('admin.logout');
        Route::get('admin/users',[AdminUserController::class,'index'])->name('admin.users');
        Route::get('admin//affiliate/users',[AdminUserController::class,'affiusers'])->name('admin.affiusers');
        Route::get('admin/course',[CourseController::class,'index'])->name('admin.course');
        Route::get('admin/add/course',[CourseController::class,'add'])->name('admin.addcourse');
        Route::get('admin/edit/course/{id}',[CourseController::class,'edit'])->name('admin.editcourse');
        Route::post('admin/delete/course/{id}',[CourseController::class,'courseDelete'])->name('courseDelete');
        Route::post('admin/store/course',[CourseController::class,'store'])->name('courses.store');
        Route::post('admin/update/course/{courseId}',[CourseController::class,'courseUpdate'])->name('courseUpdate');
        Route::resource('category', CategoryController::class);
        Route::post('/module/remove', [CourseController::class, 'remove'])->name('module.remove');
        Route::resource('blog', AdminBlogController::class);
        Route::resource('coupon', CouponController::class);
        Route::resource('payment', PaymentMethodController::class);
        Route::get('admin/orders',[OrderController::class,'orders'])->name('admin.orders');
        Route::get('admin/orders/completed',[OrderController::class,'completedorders'])->name('admin.completedorders');
        Route::get('admin/orders/canceled',[OrderController::class,'canceledorders'])->name('admin.canceledorders');
        Route::get('admin/orders/status/canceled/{id}',[OrderController::class,'cancel'])->name('admin.cancel.order');
        Route::get('admin/orders/status/complete/{id}',[OrderController::class,'complete'])->name('admin.complete.order');
        Route::get('admin/orders/status/delete/{id}',[OrderController::class,'delete'])->name('admin.delete.order');
        Route::get('admin/affiliate/commission',[AdminUserController::class,'commission'])->name('admin.affcommission');
        Route::get('admin/affiliate/payment',[AdminUserController::class,'affpayment'])->name('admin.affpayment');
        Route::post('/payRequest/{id}', [AdminUserController::class, 'payRequest'])->name('payRequest');
        Route::get('admin/combo/courses',[ComboController::class,'comboCourses'])->name('comboCourses');
        Route::post('/combo/Store', [ComboController::class, 'comboStore'])->name('comboStore');
        Route::post('/combo/update/{id}', [ComboController::class, 'comboUpdate'])->name('comboUpdate');
        Route::post('/combo/destroy/{id}', [ComboController::class, 'comboDestroy'])->name('comboDestroy');
        Route::get('admin/admin/profile',[DashboardController::class,'adminProfile'])->name('admin.adminProfile');
        Route::post('admin/admin/profile/change',[DashboardController::class,'Profilechange'])->name('admin.Profilechange');
        Route::get('admin/site/Settings',[SiteSettingController::class,'siteSetting'])->name('admin.siteSetting');
        Route::post('admin/site/Setting/update',[SiteSettingController::class,'siteSettingUpdate'])->name('admin.siteSettingUpdate');
        Route::post('admin/site/other/Setting/update',[SiteSettingController::class,'siteSettingUpdatetwo'])->name('admin.siteSettingUpdatetwo');
        Route::get('admin/site/home/Setting',[SiteSettingController::class,'homeSetting'])->name('admin.homeSetting');
        Route::post('admin/site/home/Settings/update',[SiteSettingController::class,'homeSettingUpdate'])->name('admin.homeSettingUpdate');
        Route::post('admin/site/home/Settings/update/two',[SiteSettingController::class,'homeSettingUpdatetwo'])->name('admin.homeSettingUpdatetwo');
        Route::post('admin/site/home/Settings/update/three',[SiteSettingController::class,'homeSettingUpdatethree'])->name('admin.homeSettingUpdatethree');
        Route::post('admin/site/home/Settings/update/four',[SiteSettingController::class,'homeSettingUpdatefour'])->name('admin.homeSettingUpdatefour');
        Route::get('admin/user/Status/Change/{id}',[AdminUserController::class,'userStatusChange'])->name('userStatusChange');
        Route::get('admin/admin/manages',[AdminManageController::class,'adminManager'])->name('admin.manager');
        Route::get('admin/access/manage',[AdminManageController::class,'adminAccessManage'])->name('admin.access.manage');
        Route::post('admin/admin/UManage/pdate/{id}',[AdminManageController::class,'adminUManagepdate'])->name('adminUManagepdate');
        Route::post('admin/adminManageStore',[AdminManageController::class,'adminManageStore'])->name('adminManageStore');
        Route::post('admin/admin/Manage/Destroy/{id}',[AdminManageController::class,'adminManageDestroy'])->name('adminManageDestroy');
        Route::get('admin/free/course/users',[FreeCourseController::class,'freeusers'])->name('admin.freeusers');
    });

});
