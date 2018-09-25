<?php

use Illuminate\Http\Request;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//owner routes 
Route::get('/owner/login','OwnerController@login_test');// login 
Route::post('/owner/login','OwnerController@login');// login 
Route::get('/owner/signup','OwnerController@signup_test'); 
Route::post('/owner/signup','OwnerController@signup'); 
// Route::get('/owner/{owner}',"OwnerController@show"); // owner (show and edit) 

// reset passwrod for owner 
Route::get('/owner/mail_test',"OwnerController@send_mail_test"); 
Route::post('/owner/mail',"OwnerController@send_mail"); 
Route::post('/owner/reset',"OwnerController@reset_pass"); 


// Bussines routes (show,update,store,destroy)
Route::get('/bussines/create',"BussinesController@create"); 
Route::get('/bussines/{bussines}/edit','BussinesController@edit');
Route::post('/bussines/store',"BussinesController@store");
Route::get('/bussines/{bussines}',"BussinesController@show"); 
Route::post('/bussines/{bussines}','BussinesController@update');


// files routes 
Route::get('/files/create',"FileController@create"); 
Route::post('/files/store',"FileController@store")->name('file_store');

Route::get('/files/{file}/edit','FileController@edit');
Route::post('/files/{file}','FileController@update');

Route::get('/files/delete/{file}','FileController@test_delete');
Route::delete('/files/{file}','FileController@destroy');
// Route::get('/files/{bussines}',"FileController@show"); // bussiness profile(show and edit)



// Offer routes 
// Route::apiResource('offers',"OfferController",["only"=>['store','']]); 
Route::get('/offers/create','OfferController@create'); // test create offer 
Route::get('/offers','OfferController@index'); // index :show offers for one bussines  
Route::post('/offers','OfferController@store'); // store 
Route::get('/offers/{offer}','OfferController@show');

Route::get('/offers/delete/{offer}','OfferController@test_delete');
Route::delete('/offers/{offer}','OfferController@destroy'); // delete one offer 

Route::post('/offers/{offer}','OfferController@update');
Route::get('/offers/{offer}/edit','OfferController@edit');




// Favoitre Routes 
Route::get('/favoirtes/create',"FavoirteController@create"); 
Route::post('/favoirtes',"FavoirteController@store") ; 
Route::delete('/favoirtes/{favoirte}',"FavoirteController@destroy"); 
Route::get('/favoirtes/{searcher_id}',"FavoirteController@index"); // show all favourtes for on searcher 

// Ratings  Routes 
Route::get('/ratings/store_test',"RatingController@store_test");
Route::post('/ratings',"RatingController@store");

Route::get('/ratings/{rating}/edit',"RatingController@update_test");
Route::post('/ratings/{rating}',"RatingController@update") ; 

Route::get('/ratings/{bussines}',"RatingController@bussines_rating");

// searcher routes  
Route::get('/searchers/login_test',function(){return view('searcher.login');});
Route::post('/searchers/login' , "SearcherController@login");  



// intersets routes 
Route::get('/interests/create' , "InterestController@create"); // retrieve searcher's intersets  
Route::post('/interests' , "InterestController@store");  

Route::get('/interests/{searcher}' , "InterestController@show"); // retrieve searcher's intersets  

Route::get('/interests/{interest}/edit',"InterestController@update_test");
Route::post('/interests/{interest}' , "InterestController@update");  


// category ,cities , regoins  routes 
Route::get('/categories','CategoryController@index') ; 
Route::get('/provinces','CategoryController@provinces') ; 
Route::get('/regoins/{province_id}','CategoryController@regoins');//return regoins for one province  


// search offers  routes 
Route::get('/offers/default_search/{searcher_id}',"SearcherController@default_offer_search");
Route::get ('/offer/search_test',"SearcherController@test_search");
Route::post('/offer/search',"SearcherController@test_search_offer");

// search  bussines routes  
Route::get('/search/default_search/{searcher_id}',"SearcherController@default_bussines_search");
Route::post('/search',"SearcherController@search_bussines");
Route::get('/search',"SearcherController@test_bussines_search");
// Route::get('search/search_by_name','SearcherController@search_by_name');
// Route::post('/search/bussines_name',"SearcherController@bussines_name");
// Route::get('search/search_by_category','SearcherController@search_by_category');
// Route::post('/search/category',"SearcherController@category");




// insert province  and regoins in db 
Route::get('/province', "ProvinceController@insert_province");
Route::get('/regoins', "RegoinController@insert_regoins");


