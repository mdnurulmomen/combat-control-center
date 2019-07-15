<?php

//Route::resource('player', 'PlayerController');


Route::middleware(['api', 'cors'])->group(function (){

    
    Route::prefix('v1')->group(function () {

        Route::get('game/version', 'Api\v1\GameController@showGameVersion')->name('api.v1.game_version');
        Route::post('user', 'Api\v1\PlayerController@checkPlayerExist')->name('api.v1.user_create');
        Route::get('player/{playerId}', 'Api\v1\PlayerController@showPlayerDetails')->name('api.v1.player_show');
        Route::post('player', 'Api\v1\PlayerController@editUserInfo')->name('api.v1.player_update');
        Route::get('store', 'Api\v1\StoreController@showAllStore')->name('api.v1.store_show');
        Route::post('store', 'Api\v1\PurchaseController@purchaseStoreItem')->name('api.v1.store_purchase');
        Route::get('ads', 'Api\v1\AdController@showAllAd')->name('api.v1.ad_show');
        Route::post('game-over', 'Api\v1\GameController@updateGameOverHistory')->name('api.v1.game_over_update');
        Route::post('match-start', 'Api\v1\GameController@matchStart')->name('api.v1.match_start');
        Route::post('leaders', 'Api\v1\PlayerController@showLeaderboard')->name('api.v1.leaders_show');
        Route::post('number', 'Api\v1\PurchaseController@checkBlackListNumber')->name('api.v1.blacklist_check');
        Route::post('assets/update', 'Api\v1\PlayerController@updateMultipleAssets')->name('api.v1.multiple_assets_update');
        Route::get('treasure', 'Api\v1\TreasureController@treasureIdentifier')->name('api.v1.treasure_identifier');
        Route::post('treasure', 'Api\v1\TreasureController@playerTreasureList')->name('api.v1.player_treasure_list');
        Route::post('treasure/redemption', 'Api\v1\TreasureController@treasureRedemption')->name('api.v1.treasure_redemption');


        Route::post('subscription', 'Api\v1\SubscriptionController@showPlayerSubscriptionDetails')->name('api.v1.subscription_detail_show');
        Route::post('subscription/add', 'Api\v1\SubscriptionController@addPlayerSubscriptionPackage')->name('api.v1.player_subscription_add');

    });


    Route::prefix('v2')->group(function () {

        Route::get('game/version', 'Api\v2\GameController@showGameVersion')->name('api.v2.game_version');
        Route::post('user', 'Api\v2\PlayerController@checkPlayerExist')->name('api.v2.user_create');
        Route::get('player/{playerId}/show', 'Api\v2\PlayerController@showPlayerDetails')->name('api.v2.player_show'); 
        Route::post('player/show', 'Api\v2\PlayerController@showPlayerDetails')->name('api.v2.player_show_2');
        Route::post('player', 'Api\v2\PlayerController@editUserInfo')->name('api.v2.player_update');
        Route::get('store', 'Api\v2\StoreController@showAllStore')->name('api.v2.store_show');
        Route::post('store', 'Api\v2\PurchaseController@purchaseStoreItem')->name('api.v2.store_purchase');
        Route::get('ads', 'Api\v2\AdController@showAllAd')->name('api.v2.ad_show');
        Route::post('game-over', 'Api\v2\GameController@updateGameOverHistory')->name('api.v2.game_over_update');
        Route::post('match-start', 'Api\v2\GameController@matchStart')->name('api.v2.match_start');
        Route::post('leaders', 'Api\v2\PlayerController@showLeaderboard')->name('api.v2.leaders_show');
        Route::post('number', 'Api\v2\PurchaseController@checkBlackListNumber')->name('api.v2.blacklist_check');
        Route::post('assets/update', 'Api\v2\PlayerController@updateMultipleAssets')->name('api.v2.multiple_assets_update');
        Route::get('treasure', 'Api\v2\TreasureController@treasureIdentifier')->name('api.v2.treasure_identifier');
        Route::post('treasure', 'Api\v2\TreasureController@playerTreasureList')->name('api.v2.player_treasure_list');
        Route::post('treasure/redemption', 'Api\v2\TreasureController@treasureRedemption')->name('api.v2.treasure_redemption');

        Route::post('subscription', 'Api\v2\SubscriptionController@showPlayerSubscriptionDetails')->name('api.v2.subscription_detail_show');
        Route::post('subscription/add', 'Api\v2\SubscriptionController@addPlayerSubscriptionPackage')->name('api.v2.player_subscription_add');

        Route::post('vendors', 'Api\v2\VendorController@showAllRelatedVendors')->name('api.v2.related_vendors_detail');

    });


});
