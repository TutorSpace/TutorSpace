<?php

use App\Http\Middleware\InvalidUser;
use Illuminate\Support\Facades\Route;


// for testing
Route::get('/test', 'testController@index');

// autocomplete
Route::group([
    'prefix' => 'autocomplete',
], function() {
    Route::get('/data-source', 'AutoCompleteController@getData')->name('autocomplete')->withoutMiddleware(InvalidUser::class);
    Route::get('/data-source/majors', 'AutoCompleteController@getMajors')->name('autocomplete.majors')->withoutMiddleware(InvalidUser::class);
    Route::get('/data-source/minors', 'AutoCompleteController@getMinors')->name('autocomplete.minors')->withoutMiddleware(InvalidUser::class);
    Route::get('/data-source/courses', 'AutoCompleteController@getCourses')->name('autocomplete.courses')->withoutMiddleware(InvalidUser::class);
    Route::get('/data-source/tags', 'AutoCompleteController@getTags')->name('autocomplete.tags')->withoutMiddleware(InvalidUser::class);
    Route::get('/data-source/school-years', 'AutoCompleteController@getSchoolYears')->name('autocomplete.school-years')->withoutMiddleware(InvalidUser::class);
});

// index page
Route::get('/', 'GeneralController@index')->name('index');

// search for tutors in nav bar
Route::get('/search', 'SearchController@index')->name('search.index');

// subscriptions
Route::post('/subscription/subscribe', 'SubscriptionController@store')->name('subscription.store');
Route::get('/subscription/unsubscribe', 'SubscriptionController@destroy')->name('subscription.destroy');

// invite to be tutor
Route::group([
    'prefix' => 'invite',
], function() {
    Route::get('/', 'InviteController@index')->name('invite.index');
    Route::post('/{user}', 'InviteController@inviteToBeTutor')->middleware('auth')->name('invite-to-be-tutor');
    Route::post('/', 'InviteController@inviteToBeTutorWithEmail')->middleware('auth')->name('invite-to-be-tutor--email');
});

// upload photo
Route::post('/upload-profile-pic', 'GeneralController@uploadProfilePic')->middleware('auth')->name('upload-profile-pic');

// calendar
Route::group([
    'prefix' => 'calendar'
], function() {
    Route::post('/availableTime', 'CalendarController@addAvailableTime')->name('availableTime.store');
    Route::delete('/availableTime', 'CalendarController@deleteAvailableTime')->name('availableTime.delete');
});

// bookmark
Route::group([
    'prefix' => 'bookmark'
], function() {
    Route::post('/{user}', 'BookmarkController@store')->name('bookmark.store');
    Route::delete('/{user}', 'BookmarkController@delete')->name('bookmark.delete');

    // get a single user_card
    Route::get('/{user}', 'BookmarkController@show')->name('bookmark.show');
});

// recommended tutors
Route::get('/recommended-tutors', 'GeneralController@getRecommendedTutors')->middleware('auth')->name('recommended-tutors');

// private policy
Route::get('/policy', 'GeneralController@showPrivatePolicy')->name('policy.show');

// ============================  auth  ========================
Route::group([
    'prefix' => 'auth'
], function () {
    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->withoutMiddleware(InvalidUser::class)->name('logout');

    // send verification email for register
    Route::get('/register/send-verification-email', 'Auth\RegisterController@sendVerificationEmail');

    // google callback for register & login
    Route::get('callback', 'Auth\GoogleController@handleGoogleCallback');

    // ====================== register student =====================
    Route::get('/register/student/1', 'Auth\RegisterController@indexStudent1')->name('register.index.student.1');
    Route::post('/register/student/1', 'Auth\RegisterController@storeStudent1')->name('register.store.student.1');
    Route::get('register/google/student', 'Auth\GoogleController@registerRedirectToGoogleStudent')->name('register.google.student');

    Route::get('/register/student/2', 'Auth\RegisterController@indexStudent2')->name('register.index.student.2');
    Route::post('/register/student/2', 'Auth\RegisterController@storeStudent2')->name('register.store.student.2');

    Route::get('/register/student/3', 'Auth\RegisterController@indexStudent3')->name('register.index.student.3');
    Route::post('/register/student/3', 'Auth\RegisterController@storeStudent3')->name('register.store.student.3');


    // ====================== register tutor =====================
    Route::get('/register/tutor/1', 'Auth\RegisterController@indexTutor1')->name('register.index.tutor.1');
    Route::post('/register/tutor/1', 'Auth\RegisterController@storeTutor1')->name('register.store.tutor.1');
    Route::get('register/google/tutor', 'Auth\GoogleController@registerRedirectToGoogleTutor')->name('register.google.tutor');

    Route::get('/register/tutor/2', 'Auth\RegisterController@indexTutor2')->name('register.index.tutor.2');
    Route::post('/register/tutor/2', 'Auth\RegisterController@storeTutor2')->name('register.store.tutor.2');

    Route::get('/register/tutor/3', 'Auth\RegisterController@indexTutor3')->name('register.index.tutor.3');
    Route::post('/register/tutor/3', 'Auth\RegisterController@storeTutor3')->name('register.store.tutor.3');
    Route::get('/register/tutor/4', 'Auth\RegisterController@indexTutor4')->name('register.index.tutor.4');
    Route::post('/register/tutor/4', 'Auth\RegisterController@storeTutor4')->name('register.store.tutor.4');
    Route::get('/register/tutor/5', 'Auth\RegisterController@indexTutor5')->name('register.index.tutor.5');
    Route::post('/register/tutor/5', 'Auth\RegisterController@storeTutor5')->name('register.store.tutor.5');

    // =============== login student ===============
    Route::get('/login/student', 'Auth\LoginController@indexStudent')->name('login.index.student');
    Route::post('/login/student', 'Auth\LoginController@storeStudent')->name('login.store.student');
    Route::get('login/google/student', 'Auth\GoogleController@loginRedirectToGoogleStudent')->name('login.google.student');

    // =============== login tutor ===============
    Route::get('/login/tutor', 'Auth\LoginController@indexTutor')->name('login.index.tutor');
    Route::post('/login/tutor', 'Auth\LoginController@storeTutor')->name('login.store.tutor');
    Route::get('login/google/tutor', 'Auth\GoogleController@loginRedirectToGoogleTutor')->name('login.google.tutor');

    // ================ reset password ============
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


    // ================ password confirm ==========
    Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
});


// ===============================  Forum  ==========================
Route::group([
    'prefix' => 'forum'
], function () {
    Route::get('/posts/search-results', 'Forum\PostController@search')->name('posts.search');
    Route::get('/posts/popular', 'Forum\PostController@indexPopular')->name('posts.popular');
    Route::get('/posts/latest', 'Forum\PostController@indexLatest')->name('posts.latest');
    Route::get('posts/my-follows', 'Forum\PostController@showMyFollows')->name('posts.my-follows');
    Route::get('posts/my-posts', 'Forum\PostController@showMyPosts')->name('posts.my-posts');
    Route::get('posts/my-participated', 'Forum\PostController@showMyParticipated')->name('posts.my-participated');
    Route::resource('posts', 'Forum\PostController');

    Route::post('posts/upload-img', 'Forum\PostController@uploadPostImg')->name('upload-post-img');
    Route::post('posts/draft', 'Forum\PostController@storeAsDraft')->name('post-draft.store');
    Route::post('posts/upvote/{post}', 'Forum\PostController@upvote')->name('post.upvote');
    Route::post('posts/follow/{post}', 'Forum\PostController@follow')->name('post.follow');

    Route::post('posts/{post}/replies/reply', 'Forum\ReplyController@storeReply')->name('posts.reply.store');
    Route::post('posts/replies/{reply}/upvote', 'Forum\ReplyController@upvote')->name('posts.reply.upvote');
    Route::post('posts/replies/{reply}/followup', 'Forum\ReplyController@storeFollowup')->name('posts.followup.store');

    Route::post('/posts/mark-best-reply/{post}/{reply}', 'Forum\PostController@markAsBestReply')->name('posts.markBestReply');

    // report
    Route::post('/report', 'GeneralController@storeReport')->middleware('auth')->name('forum.report.store');

});

// home page
Route::group([
    'prefix' => 'home',
    'middleware' => 'auth'
], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/tutor-sessions', 'HomeController@tutorSessions')->name('home.tutor-sessions');
    Route::get('/forum-activities', 'HomeController@forumActivities')->name('home.forum-activities');
    Route::get('/profile', 'HomeController@indexProfile')->name('home.profile');
    Route::put('/profile', 'HomeController@update')->name('home.profile.update')->withoutMiddleware(InvalidUser::class);
    Route::post('/profile/hourly-rate', 'HomeController@updateHourlyRate')->name('home.profile.hourly-rate.update')->middleware('isTutor');
});

// view profile
Route::group([
    'prefix' => 'view-profile',
], function() {
    // optional parameter orderByOption
    Route::get('/{user}/{orderByOption?}', 'ViewProfileController@index')->name('view.profile');
});

// chatting
Route::group([
    'prefix' => 'chatting',
    'middleware' => 'auth'
], function() {
    Route::get('/', 'ChattingController@index')->name('chatting.index');
    Route::get('/get-messages', 'ChattingController@getMessages')->name('chatting.get-messages');
    Route::post('/send-msg', 'ChattingController@sendMsg')->name('chatting.send-msg');
});

// add/remove course/tag to the user profile
Route::post('/course-add-remove', 'GeneralController@addRemoveCourseToProfile')->middleware(['auth'])->withoutMiddleware(InvalidUser::class);
Route::post('/tag-add-remove', 'GeneralController@addRemoveTagToProfile')->middleware(['auth']);

// notifications
Route::group([
    'prefix' => 'notifications',
    'middleware' => 'auth'
], function() {
    Route::get('/', 'NotificationController@index')->name('notifications.index');
});

// switch account
Route::group([
    'prefix' => 'switch-account',
    'middleware' => 'auth'
], function() {
    Route::post('/register', 'SwitchAccountController@register')->name('switch-account.register');
    Route::get('/switch', 'SwitchAccountController@switch')->name('switch-account.switch');
    Route::get('/register-to-be-tutor', 'SwitchAccountController@indexRegisterToBeTutor')->withoutMiddleware(InvalidUser::class)->name('switch-account.register-to-be-tutor');
    Route::get('/register-to-be-tutor-2', 'SwitchAccountController@indexRegisterToBeTutor2')->withoutMiddleware(InvalidUser::class)->name('switch-account.index.register-to-be-tutor-2');
    Route::put('/register-to-be-tutor-2', 'SwitchAccountController@updateRegisterToBeTutor2')->withoutMiddleware(InvalidUser::class)->name('switch-account.register-to-be-tutor-2');
});

// tutor requests
Route::group([
    'prefix' => 'tutor-request',
    'middleware' => 'auth'
], function() {
    Route::post('/accept/{tutorRequest}', 'TutorRequestController@acceptTutorRequest');
    Route::delete('/{tutorRequest}', 'TutorRequestController@declineTutorRequest');
});

// tutor verification
Route::post('/tutor-verification', 'TutorProfileVerificationController@sendVerificationEmails')->name('tutor-profile-verification')->middleware('isTutor');

// sessions
Route::group([
    'prefix' => 'session',
    'middleware' => 'auth'
], function() {
    Route::post('/cancel/{session}', 'SessionController@cancelSession')->name('session.cancel');
    Route::post('/schedule', 'SessionController@scheduleSession')->name('session.create');
    Route::get('/view/{session}', 'SessionController@viewDetails')->name('session.view-details');
    Route::post('/review/{session}', 'SessionController@review')->name('session.review');
});

// help center
Route::group([
    'prefix' => 'help-center'
], function() {
    Route::get('/', 'HelpCenterController@index')->name('help-center.index');
});

// Stripe
Route::group([
    'prefix' => 'payment/stripe',
    'middleware' => 'auth'
], function() {
    Route::post('/onboarding', 'payment\StripeApiController@createAccountLink')->name('payment.stripe.onboarding');
    Route::get('/list_cards', 'payment\StripeApiController@listCards')->name('payment.stripe.list-cards');

    Route::get('/add_payment_method', 'payment\StripeApiController@saveCardIndex')->name('payment.stripe.save-card');
    Route::post('/create_payment_intent', 'payment\StripeApiController@createPaymentIntent')->name('payment.stripe.create_payment_intent');
    Route::get('/check', 'payment\StripeApiController@checkAccountDetail')->name('payment.stripe.check');
    Route::post('/detach_payment', 'payment\StripeApiController@detachPayment')->name('payment.stripe.detach_payment');
    //Stripe set payment as Customer Invoice Default
    Route::post('/set_payment_invoice_default', 'payment\StripeApiController@saveCardAsDefault')->name('payment.stripe.set_invoice_payment_default');
    Route::post('/create_setup_intent', 'payment\StripeApiController@createSetupIntent')->name('payment.stripe.create_setup_intent');

    Route::post('/webhook', 'payment\StripeApiController@handleWebhook')->withoutMiddleware(['auth'])->name('payment.stripe.webhook');
    Route::post('/connect/webhook', 'payment\StripeApiController@handleConnectWebhook')->withoutMiddleware(['auth'])->name('payment.stripe.connect.webhook');

    Route::get('/refund', 'payment\StripeApiController@refundIndex')->name('payment.stripe.refund.index')->middleware('isAdmin');
    Route::post('/user-request-refund/{session}', 'payment\StripeApiController@userRequestRefund')->name('payment.stripe.refund.user_request_refund');
    Route::post('/refund/{session}', 'payment\StripeApiController@approveRefund')->name('payment.stripe.approve_refund')->middleware('isAdmin');
    Route::post('/refund/decline/{session}', 'payment\StripeApiController@declineRefundRequest')->name('payment.stripe.decline_refund')->middleware('isAdmin');

    Route::get('/redirect-to-payment/{session}', 'payment\StripeApiController@redirectToPayment')->name('payment.stripe.redirect-payment');
});


// ================== Stripe testing ======================
// Route::get('/payment/stripe_index', 'payment\StripeApiController@index');
// Route::get('/payment/refund', 'payment\StripeApiController@refundIndex');

// Route::get('/payment/save_card', 'payment\StripeApiController@testSaveCard');

// Route::post('/payment/stripe_payout', 'payment\StripeApiController@processPayout');
// // Route::get('/payment/check', 'payment\StripeApiController@checkAccountDetail');
// Route::post('/payment/create_payment_intent_with_card', 'payment\StripeApiController@createPaymentIntentWithCard');
// Route::post('/payment/confirm_payment_intent', 'payment\StripeApiController@confirmPaymentIntent');

// // Stripe Invoice
// Route::get('/payment/invoice_index', 'payment\StripeApiController@invoiceIndex')->name('invoice_index');
// Route::post('/payment/create_invoice', 'payment\StripeApiController@createInvoice');

