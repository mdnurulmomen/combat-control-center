<?php

//Route::resource('player', 'PlayerController');

Route::middleware(['api', 'cors'])->group(function (){

    Route::get('game/version', 'Api\GameController@showGameVersion')->name('api.game_version');

    Route::post('user', 'Api\PlayerController@checkPlayerExist')->name('api.user_create');

    Route::get('player/{playerId}/view', 'Api\PlayerController@showPlayerDetails')->name('api.player_view'); 
    Route::post('player/view', 'Api\PlayerController@showPlayerDetails')->name('api.player_view_2');

    Route::post('player', 'Api\PlayerController@editUserInfo')->name('api.player_update');

    Route::get('store', 'Api\StoreController@showAllStore')->name('api.store_all');
    Route::post('store', 'Api\PurchaseController@purchaseStoreItem')->name('api.purchase_store_item');

    Route::get('ads', 'Api\AdController@showAllAd')->name('api.ad_all');
    
    Route::post('game-over', 'Api\GameController@updateGameOverHistory')->name('api.game_over_update');

    Route::post('match-start', 'Api\GameController@matchStart')->name('api.match_start');

    Route::post('leaders', 'Api\PlayerController@showLeaderboard')->name('api.leaders');
    
    Route::post('number', 'Api\PurchaseController@checkBlackListNumber')->name('api.check_blacklist');

    Route::post('assets/update', 'Api\PlayerController@updateMultipleAssets')->name('api.update_multiple_assets');

    Route::get('treasure', 'Api\TreasureController@treasureIdentifier')->name('api.treasure_identifier');

    Route::post('treasure', 'Api\TreasureController@playerTreasureList')->name('api.player_treasure_list');
    
    Route::post('treasure/redemption', 'Api\TreasureController@treasureRedemption')->name('api.treasure_redemption');

    //Route::post('treasure/{treasureId}/player/{playerId}/add', 'Api\TreasureController@addPlayerTreasure')->name('api.player_treasure_add');

    /*
    Route::get('player/all', 'Api\PlayerController@showAllPlayer')->name('api.player_view_all');
    
    Route::post('delete/player/{playerId}', 'PlayerController@deletePlayerMethod')->name('api.delete.player');
    */

    /*
    Route::post('character/{characterId}/player/{playerId}/add', 'Api\PlayerController@addPlayerCharacter')->name('api.player_character_add');

    Route::post('weapon/{weaponId}/player/{playerId}/add', 'Api\PlayerController@addPlayerWeapon')->name('api.player_weapon_add');
    */
});
