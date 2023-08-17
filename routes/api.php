<?php

use Illuminate\Support\Facades\Route;

//Route::resource('player', 'PlayerController');

Route::middleware(['api'])->group(function (){


    Route::prefix('v1')->group(function () {

        Route::get('game/version', [Api\v1\GameController::class, 'showGameVersion'])->name('api.v1.game_version');
        Route::post('user', [Api\v1\PlayerController::class, 'checkPlayerExist'])->name('api.v1.user_create');
        Route::get('player/{playerId}/show', [Api\v1\PlayerController::class, 'showPlayerDetails'])->name('api.v1.player_show');
        Route::post('player/show', [Api\v1\PlayerController::class, 'showPlayerDetails'])->name('api.v1.player_show_2');
        Route::post('player', [Api\v1\PlayerController::class, 'editUserInfo'])->name('api.v1.player_update');
        Route::get('store', [Api\v1\StoreController::class, 'showAllStore'])->name('api.v1.store_show');
        Route::post('store', [Api\v1\PurchaseController::class, 'purchaseStoreItem'])->name('api.v1.store_purchase');
        Route::post('game-over', [Api\v1\GameController::class, 'updateGameOverHistory'])->name('api.v1.game_over_update');
        Route::post('match-start', [Api\v1\GameController::class, 'matchStart'])->name('api.v1.match_start');
        Route::post('leaders', [Api\v1\PlayerController::class, 'showLeaderboard'])->name('api.v1.leaders_show');
        Route::post('number', [Api\v1\PurchaseController::class, 'checkBlackListNumber'])->name('api.v1.blacklist_check');
        Route::post('assets/update', [Api\v1\PlayerController::class, 'updateMultipleAssets'])->name('api.v1.multiple_assets_update');
        Route::get('treasure', [Api\v1\TreasureController::class, 'treasureIdentifier'])->name('api.v1.treasure_identifier');
        Route::post('treasure', [Api\v1\TreasureController::class, 'playerTreasureList'])->name('api.v1.player_treasure_list');
        Route::post('treasure/redemption', [Api\v1\TreasureController::class, 'treasureRedemption'])->name('api.v1.treasure_redemption');

        Route::post('subscription', [Api\v1\SubscriptionController::class, 'showPlayerSubscriptionDetails'])->name('api.v1.subscription_detail_show');
        Route::post('subscription/add', [Api\v1\SubscriptionController::class, 'addPlayerSubscriptionPackage'])->name('api.v1.player_subscription_add');

        Route::post('vendors', [Api\v1\VendorController::class, 'showAllRelatedVendors'])->name('api.v1.related_vendors_detail');

        Route::post('missions', [Api\v1\MissionController::class, 'showPlayerMissions'])->name('api.v1.set_player_missions');

        Route::get('ad-campaign', [Api\v1\AdController::class, 'showAllCampaignsAndImages'])->name('api.v1.show_campaigns_detail');
        Route::post('ad-campaign', [Api\v1\AdController::class, 'updateGameCampaignDetails'])->name('api.v1.update_game_campaign');

    });


    Route::prefix('v2')->group(function () {

        Route::get('game/version', [Api\v2\GameController::class, 'showGameVersion'])->name('api.v2.game_version');
        Route::post('user', [Api\v2\PlayerController::class, 'checkPlayerExist'])->name('api.v2.user_create');
        Route::get('player/{playerId}/show', [Api\v2\PlayerController::class, 'showPlayerDetails'])->name('api.v2.player_show');
        Route::post('player/show', [Api\v2\PlayerController::class, 'showPlayerDetails'])->name('api.v2.player_show_2');
        Route::post('player', [Api\v2\PlayerController::class, 'editUserInfo'])->name('api.v2.player_update');
        Route::get('store', [Api\v2\StoreController::class, 'showAllStore'])->name('api.v2.store_show');
        Route::post('store', [Api\v2\PurchaseController::class, 'purchaseStoreItem'])->name('api.v2.store_purchase');
        Route::post('game-over', [Api\v2\GameController::class, 'updateGameOverHistory'])->name('api.v2.game_over_update');
        Route::post('match-start', [Api\v2\GameController::class, 'matchStart'])->name('api.v2.match_start');
        Route::post('leaders', [Api\v2\PlayerController::class, 'showLeaderboard'])->name('api.v2.leaders_show');
        Route::post('number', [Api\v2\PurchaseController::class, 'checkBlackListNumber'])->name('api.v2.blacklist_check');
        Route::post('assets/update', [Api\v2\PlayerController::class, 'updateMultipleAssets'])->name('api.v2.multiple_assets_update');
        Route::get('treasure', [Api\v2\TreasureController::class, 'treasureIdentifier'])->name('api.v2.treasure_identifier');
        Route::post('treasure', [Api\v2\TreasureController::class, 'playerTreasureList'])->name('api.v2.player_treasure_list');
        Route::post('treasure/redemption', [Api\v2\TreasureController::class, 'treasureRedemption'])->name('api.v2.treasure_redemption');

        Route::post('subscription', [Api\v2\SubscriptionController::class, 'showPlayerSubscriptionDetails'])->name('api.v2.subscription_detail_show');
        Route::post('subscription/add', [Api\v2\SubscriptionController::class, 'addPlayerSubscriptionPackage'])->name('api.v2.player_subscription_add');

        Route::post('vendors', [Api\v2\VendorController::class, 'showAllRelatedVendors'])->name('api.v2.related_vendors_detail');

        Route::post('missions', [Api\v2\MissionController::class, 'showPlayerMissions'])->name('api.v2.set_player_missions');

        Route::get('ad-campaign', [Api\v2\AdController::class, 'showAllCampaignsAndImages'])->name('api.v2.show_campaigns_detail');
        Route::post('ad-campaign', [Api\v2\AdController::class, 'updateGameCampaignDetails'])->name('api.v2.update_game_campaign');

    });

    Route::fallback(function(){
        return response()->json([
                'error'=>'Incorrect route'
            ], 404);
    });
});
