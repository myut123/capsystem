<?php

use App\Http\Controllers\AdminHome;
use App\Http\Controllers\AllPetListing;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CatListing;
use App\Http\Controllers\DogListing;
use App\Http\Controllers\EditCategory;
use App\Http\Controllers\EditContent;
use App\Http\Controllers\getLoc;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\preferenceController;
use App\Http\Controllers\registrationController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PetShow;
use App\Http\Controllers\petUpload;
use App\Http\Controllers\qrController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\UrlParameter;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SendLocation;
use App\Http\Controllers\viewApplicant;
use App\Http\Controllers\ZoomController;
use Illuminate\Support\Facades\Session;

//location
route::get('/map',[SendLocation::class,'viewMap'])->name('view.map');
route::post('/map/save',[SendLocation::class,'saveLocation'])->name('map.save');
Route::post('/send-location-email', [SendLocation::class, 'sendLocationEmail'])->name('map.send');

//getLocation
route::get('/api/location/{idadop}',[getLoc::class,'viewLocation'])->name('pet.map');
route::get('/api/adoption_application/{idadop}',[getLoc::class,'viewLocation'])->name('pet.map');
route::get('/api/get-pet-location/{idAddress}',[getLoc::class,'getUserLocation'])->name('pet.map');

Route::get('/api/adoption_application/{idadop}', [UrlParameter::class, 'getAdoptionApplication']);

//QR Code
route::get('/qr',[qrController::class,'qrView'])->name('qr.view');
Route::post('/qr/generate', [qrController::class, 'qrGenerate'])->name('qr.generate');

//Update Profile   
Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit',[UserProfileController::class,'edit'])->name('profile.edit');
Route::get('/profile/edit-categories',[UserProfileController::class,'categories'])->name('profile.categories');
Route::post('/profile/categories/update', [UserProfileController::class, 'updateCategories'])->name('profile.categories.update');
//login/Logout
route::get('/Login',[LoginController::class,'loginview'])->name('login.view');
route::post('/submission',[LoginController::class,'login']) -> name('login.submit');
Route::post('/logout', [LogoutController::class,'logout'])->name('logout.submit');

// adoption application form
Route::get('/adoption/apply/{petId}', [ApplicationController::class, 'showApplicationForm'])->name('adoption.apply');
Route::post('/adoption/submit', [ApplicationController::class, 'submitApplication'])->name('adoption.submit');
Route::post('employ/adoption/submit', [ApplicationController::class, 'submitEmployment'])->name('employment.submit');
Route::post('identification/adoption/submit', [ApplicationController::class, 'idsubmit'])->name('identification.submit');


//View all Pets Listing
route::get('/petrecommended',[PetController::class,'viewPetListing']);
route::get('/dogrecommended',[DogListing::class,'viewDogListing']);
route::get('/catrecommended',[CatListing::class,'viewCatListing']);
route::get('/allrecommended',[AllPetListing::class,'viewAllListing']);
route::get('/recommended/placeholder/{categoryId}',[AllPetListing::class,'fetchCategoryContent']);
Route::get('/category/{categoryId}/pets',[AllPetListing::class,'showpet']);
Route::get('/pets/all',[AllPetListing::class,'getAllPets']);
Route::get('/pets', [AllPetListing::class, 'getAllPets'])->name('pets.getAll');


Route::get('/recommend-pets', [AllPetListing::class, 'recommendPets'])->name('recommend.pets');


// Route to get user preferences
Route::get('/user/preferences', [AllPetListing::class, 'getUserPreferences'])->name('user.preferences');

// Route to get pets with categories (for recommendations, etc.)
Route::get('/pets/with-categories', [AllPetListing::class, 'getPetsWithCategories'])->name('pets.withCategories');

// Route to recommend pets based on hybrid scoring
Route::get('/pets/recommend', [AllPetListing::class, 'recommendPets'])->name('pets.recommend');
Route::get('/category/{categoryId}/pets', [AllPetListing::class, 'showPetsByCategory']);


//Show Pet details Page
Route::get('/petshow', [PetShow::class, 'petshowdata']);
Route::post('/pet/{idpet}', [PetShow::class, 'clickablepet'])->name('pet.show');
Route::get('/pet/{idpet}', [PetShow::class, 'clickablepet'])->name('pet.show');
Route::get('/compatibility/{petId}', [PetShow::class, 'getCompatibility']);

//Pet Upload
Route::get('/pet-upload', [PetUpload::class, 'showstaffPage'])->name('petUpload.form');
Route::post('/pet-upload/inserted', [PetUpload::class, 'store'])->name('petUpload.insert');

//staff
Route::get('/applicants', [ScreeningController::class, 'applicant'])->name('applicant');

// Route for accepting an applicant
Route::post('/applicants/{id}/accept', [ScreeningController::class, 'acceptApplicant'])->name('applicant.accept');

// Route for rejecting an applicant
Route::post('/applicants/{id}/reject', [ScreeningController::class, 'rejectApplicant'])->name('applicant.reject');

//Homepage
route::get('/homepage',[HomeController::class,'showHome'])->name('home.view');
Route::get('/fetch-data', [HomeController::class, 'fetchcampaign'])->name('fetch.data');

//viewApplicant
Route::get('/applications/{id}', [viewApplicant::class, 'show'])->name('application.show');



//registration
route::get('/register',[registrationController::class,'registrationview'])->name('register.link');
route::post('/register',[registrationController::class,'registrationview'])->name('register.link');
route::get('/register/create',[registrationController::class,'registration']) -> name('register.submit');
route::post('/register/create',[registrationController::class,'registration']) -> name('register.submit');
Route::post('/id-card-upload', [registrationController::class, 'registerSubmit'])->name('idCard.upload');

//preference
Route::get('/category/welcome', [preferenceController::class, 'showWelcome'])->name('preference.view');
Route::get('/category/{id}', [preferenceController::class, 'showCategories'])->name('preferencecategories.view');
Route::post('/preferences/store', [PreferenceController::class, 'storeSelection'])->name('preferences.store');
Route::post('/preference', [preferenceController::class, 'showAdoptionForm'])->name('pets.adoption-form');
Route::get('/pets/match', [preferenceController::class, 'matchPreferences'])->name('pets.match');
Route::post('/pets/match', [preferenceController::class, 'matchPreferences'])->name('pets.match');


//OTP
Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send.otp');
Route::get('/otp-request', [OtpController::class, 'showEmailForm'])->name('otp.request'); 
Route::get('/view-otp', [OtpController::class, 'viewOtp'])->name('view.otp');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [OtpController::class, 'resendOtp'])->name('resend.otp');

//Edit Categories
Route::get('/Admin/Homepage',[AdminHome::class, 'viewAdmin'])->name('admin.home');
Route::get('/Admin/Update/Category',[EditCategory::class,'viewUpdateCategory'])->name('view.edit');
Route::get('/analytics', [EditCategory::class, 'getAnalyticsData'])->name('analytics.view');
Route::post('/Admin/Update/Add/Category', [EditCategory::class, 'addCategoryAndSelections'])->name('add.category.with.selections');
Route::post('/update/category', [EditCategory::class, 'updateCategory'])->name('update.category');
Route::post('/update/selection/', [EditCategory::class, 'updateSelection'])->name('update.selection');
Route::post('/delete/category', [EditCategory::class, 'deleteCategory'])->name('delete.category');
Route::get('/categories/{$categoryId}/selections', [EditCategory::class, 'getSelections']);
Route::get('/search-categories', [EditCategory::class, 'searchCategories'])->name('search.categories');
Route::get('/get-selections', [EditCategory::class, 'getSelections'])->name('get.selections');
Route::post('/delete/selection/', [EditCategory::class, 'deleteSelection'])->name('delete.selection');
Route::post('/restore-category', [EditCategory::class, 'restoreCategory']);

Route::get('/search-deleted-categories', [EditCategory::class, 'searchDeletedCategories'])->name('search.deleted.categories');

Route::get('/get-deleted-selections', [EditCategory::class, 'getDeletedSelections'])->name('get.deleted.selections');



//zoom meetings
Route::get('/zoom', [ZoomController::class, 'showZoom'])->name('show.zoom');
Route::get('/oauth/zoom/', [OAuthController::class, 'redirectToProvider'])->name('oauth.zoom');

Route::get('/oauth/callback', [OAuthController::class, 'handleProviderCallback']);
Route::get('/zoom/schedule', [ZoomController::class, 'showScheduleForm'])->name('sched.view');
Route::post('/zoom/schedule', [ZoomController::class, 'scheduleMeeting']);
Route::get('/zoom/meetings', [ZoomController::class, 'showMeetingForm'])->name('zoom.meetings');

//campaign
route::get('/campaign/upload-view',[EditContent::class, 'viewCampaign'])->name('view.campaign');
route::post('/campaign/upload',[EditContent::class,'storeCampaign'])->name('store.campaign');
Route::post('/update-campaign', [EditContent::class, 'update'])->name('update.campaign');
Route::get('/search-campaigns', [EditContent::class, 'search'])->name('search.campaigns');




Route::fallback(function () {
    return 'There is nothing here';
});
