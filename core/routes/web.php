<?php

Route::get('/', 'Web\AdminController@index');

Route::group(['prefix'=>'admin', 'middleware'=>'web'], function (){

    Route::group(['middleware'=>'guest:admin'], function ()
    {
        Route::get('/', 'Web\AdminController@showLoginForm')->name('admin.login');
        Route::post('/', 'Web\AdminController@login')->name('admin.login_submit'); 
    });

    Route::group(['middleware'=>['verified.OTP']], function ()
    {
        Route::get('email-otp', 'Web\AdminController@showOTP')->name('admin.otp');
        Route::get('resend-email-otp/{adminId}', 'Web\AdminController@generateNewOTPToken')->name('admin.generate_new_otp_code');
        Route::post('email-otp', 'Web\AdminController@submitOTPCode')->name('admin.submit_otp_code');
    });

    Route::group(['middleware'=>'auth:admin'], function ()
    {
        Route::get('logout', 'Web\AdminController@logout')->name('admin.logout');
        
        Route::group(['middleware'=>'check.OTP'], function ()
        {
            Route::get('home', 'Web\AdminController@homeMethod')->name('admin.home');
        
            Route::get('profile', 'Web\AdminController@showProfileForm')->name('admin.update_profile');
            Route::put('profile', 'Web\AdminController@submitProfileForm')->name('admin.updated_profile_submit');
            Route::get('password', 'Web\AdminController@showPasswordForm')->name('admin.update_password');
            Route::post('password', 'Web\AdminController@submitPasswordForm')->name('admin.updated_password_submit');


            Route::group(['middleware' => ['permission:analytic']], function () {

                Route::get('analytics-talktime', 'Web\AdminController@showTalktimeAnalytics')->name('admin.show_talktime_analytics');

                Route::get('analytics-earnings', 'Web\AdminController@showEarningAnalytics')->name('admin.show_earnings_analytics');

                Route::get('analytics-treasures', 'Web\AdminController@showTreasureAnalytics')->name('admin.show_treasures_analytics');

                Route::get('analytics-gemPacks', 'Web\AdminController@showGemPacksAnalytics')->name('admin.show_gem_packs_analytics');

                // Route::get('analytics', 'Web\AdminController@showAnalyticData')->name('admin.show_analytic_data');
            }); 


            Route::group(['middleware' => ['permission:setting']], function () {

                Route::get('settings/cms', 'Web\AdminController@showAdminSettingsForm')->name('admin.settings_admin_panel');
                Route::put('settings/cms', 'Web\AdminController@submitAdminSettingsForm')->name('admin.settings_admin_panel_submit');
            });    


            Route::post('user', 'Web\AdminController@submitCreateUserForm')->name('admin.created_user_submit');
            Route::get('users/all', 'Web\AdminController@showAllUsers')->name('admin.view_users');
            Route::put('users/{userId}', 'Web\AdminController@submitUserEditForm')->name('admin.updated_user_submit');
            Route::delete('users/{userId}', 'Web\AdminController@userDeleteMethod')->name('admin.delete_user');


            Route::get('api/all', 'Web\AdminController@showAllApi')->name('admin.view_api');

            Route::group(['middleware' => ['permission:setting']], function () {

                Route::get('game/settings', 'Web\GameController@showGameSettingsForm')->name('admin.settings_game');
                Route::put('game/settings', 'Web\GameController@submitGameSettingsForm')->name('admin.settings_game_submit');


                Route::get('rules/settings', 'Web\GameController@showRulesSettingsForm')->name('admin.settings_rules');
                Route::put('rules/settings', 'Web\GameController@submitRulesSettingsForm')->name('admin.settings_rules_submit');


                Route::get('gift-treasures', 'Web\GiftController@showTreasureSettingsForm')->name('admin.settings_gift_treasure');
                Route::put('gift-treasures', 'Web\GiftController@submitTreasureSettingsForm')->name('admin.settings_gift_treasure_submit');


                Route::get('gift-animations', 'Web\GiftController@showGiftAnimations')->name('admin.settings_gift_animations');
                Route::put('gift-animations', 'Web\GiftController@submitGiftAnimations')->name('admin.settings_gift_animations_submit');


                Route::get('gift-boostpacks', 'Web\GiftController@showGiftBoostPacks')->name('admin.settings_gift_boost_packs');
                Route::put('gift-boostpacks', 'Web\GiftController@submitGiftBoostPacks')->name('admin.settings_gift_boost_packs_submit');


                Route::get('gift-characters', 'Web\GiftController@showGiftCharacters')->name('admin.setting_gift_characters');
                Route::put('gift-characters', 'Web\GiftController@submitGiftCharacters')->name('admin.setting_gift_characters_submit');


                Route::get('gift-parachutes', 'Web\GiftController@showGiftParachutes')->name('admin.setting_gift_parachutes');
                Route::put('gift-parachutes', 'Web\GiftController@submitGiftParachutes')->name('admin.setting_gift_parachutes_submit');


                Route::get('gift-weapons', 'Web\GiftController@showGiftWeapons')->name('admin.setting_gift_weapons');
                Route::put('gift-weapons', 'Web\GiftController@submitGiftWeapons')->name('admin.setting_gift_weapons_submit'); 


                Route::get('gift-points', 'Web\GiftController@showGiftPoints')->name('admin.setting_gift_points');
                Route::put('gift-points', 'Web\GiftController@submitGiftPoints')->name('admin.setting_gift_points_submit');        
            });



            Route::get('players/all', 'Web\PlayerController@showAllPlayers')->name('admin.view_players');
            Route::put('player/{playerId}/', 'Web\PlayerController@submitPlayerEditForm')->name('admin.updated_player_submit');
            Route::delete('player/{playerId}', 'Web\PlayerController@deletePlayerMethod')->name('admin.delete_player');

            
            Route::get('bots/all', 'Web\PlayerController@showAllBots')->name('admin.view_bots');
            Route::post('bot', 'Web\PlayerController@submitCreateBotForm')->name('admin.created_bot_submit');
            // Route::get('bot/{botId}', 'Web\PlayerController@showBotEditForm')->name('admin.update_bot');
            Route::put('bot/{botId}/', 'Web\PlayerController@submitBotEditForm')->name('admin.updated_bot_submit');
            
            Route::get('leaderboard', 'Web\PlayerController@showLeaderboard')->name('admin.view_leaderboard');
            Route::delete('bot/{botId}', 'Web\PlayerController@deleteBotMethod')->name('admin.delete_bot');


            Route::get('characters/enabled', 'Web\CharacterController@showEnabledCharacters')->name('admin.view_enabled_characters');
            Route::get('characters/disabled', 'Web\CharacterController@showDisabledCharacters')->name('admin.view_disabled_characters');
            Route::post('characters', 'Web\CharacterController@submitCreateCharacterForm')->name('admin.created_character_submit');
            Route::patch('characters/{characterId}', 'Web\CharacterController@characterUndoMethod')->name('admin.undo_character');
            Route::put('characters/{characterId}', 'Web\CharacterController@submitCharacterEditForm')->name('admin.updated_character_submit');
            Route::delete('character/{characterId}', 'Web\CharacterController@characterDeleteMethod')->name('admin.delete_character');


            Route::get('black-list/all', 'Web\BlackListController@showBlackList')->name('admin.view_black_list');
            Route::delete('black-list/{blackListId}', 'Web\BlackListController@deleteBlackListedNumber')->name('admin.delete_black_listed_number');
            

            Route::get('treasure-types/enabled', 'Web\TreasureController@showAllEnabledTreasureTypes')->name('admin.view_enabled_treasure_types');
            Route::get('treasure-types/disabled', 'Web\TreasureController@showAllDisabledTreasureTypes')->name('admin.view_disabled_treasure_types');
            Route::post('treasure-types', 'Web\TreasureController@submitCreateTreasureTypeForm')->name('admin.created_treasure_type_submit');
            Route::put('treasure-types/{treasureTypeId}', 'Web\TreasureController@submitTreasureTypeEditForm')->name('admin.updated_treasure_type_submit');
            Route::delete('treasure-types/{treasureTypeId}', 'Web\TreasureController@treasureTypeDeleteMethod')->name('admin.delete_treasure_type');
            Route::patch('treasure-types/{treasureTypeId}', 'Web\TreasureController@treasureTypeUndoMethod')->name('admin.undo_treasure_type');


            Route::get('treasures/enabled', 'Web\TreasureController@showEnabledTreasures')->name('admin.view_enabled_treasures');
            Route::get('treasures/disabled', 'Web\TreasureController@showDisabledTreasures')->name('admin.view_disabled_treasures');
            Route::post('treasures', 'Web\TreasureController@submitCreateTreasureForm')->name('admin.created_treasure_submit');
            Route::put('treasures/{treasureId}', 'Web\TreasureController@submitTreasureEditForm')->name('admin.updated_treasure_submit');
            Route::delete('treasures/{treasureId}', 'Web\TreasureController@treasureDeleteMethod')->name('admin.delete_treasure');
            Route::patch('treasures/{treasureId}', 'Web\TreasureController@treasureUndoMethod')->name('admin.undo_treasure');


            Route::post('treasures-gifted', 'Web\TreasureController@showAllTreasureGifted')->name('admin.view_treasure_gifted');
            Route::get('treasures-redeemed', 'Web\TreasureController@showAllTreasureRedeemed')->name('admin.view_treasure_redeems');


            Route::get('treasures/requested', 'Web\TreasureController@showTreasureRequested')->name('admin.show_treasure_requested');
            Route::post('talkTime/confirmed', 'Web\TreasureController@confirmTreasureRequested')->name('admin.confirm_treasure_requested');

            
            Route::get('vendors/enabled', 'Web\VendorController@showEnabledVendors')->name('admin.view_enabled_vendors');
            Route::get('vendors/disabled', 'Web\VendorController@showDisabledVendors')->name('admin.view_disabled_vendors');
            Route::post('vendors', 'Web\VendorController@submitCreateVendorForm')->name('admin.created_vendor_submit');
            Route::put('vendors/{vendorId}', 'Web\VendorController@submitVendorEditForm')->name('admin.updated_vendor_submit');
            Route::delete('vendors/{vendorId}', 'Web\VendorController@vendorDeleteMethod')->name('admin.delete_vendor');
            Route::patch('vendors/{vendorId}', 'Web\VendorController@vendorUndoMethod')->name('admin.undo_vendor');

            Route::get('cities/enabled', 'Web\LocationController@showEnabledCities')->name('admin.view_enabled_cities');
            Route::get('cities/disabled', 'Web\LocationController@showDisabledCities')->name('admin.view_disabled_cities');
            Route::post('cities', 'Web\LocationController@submitCreateCityForm')->name('admin.created_city_submit');
            Route::put('cities/{cityId}', 'Web\LocationController@submitCityEditForm')->name('admin.updated_city_submit');
            Route::delete('cities/{cityId}', 'Web\LocationController@cityDeleteMethod')->name('admin.delete_city');
            Route::patch('cities/{cityId}', 'Web\LocationController@cityUndoMethod')->name('admin.undo_city');


            Route::get('areas/enabled', 'Web\LocationController@showEnabledAreas')->name('admin.view_enabled_areas');
            Route::get('areas/disabled', 'Web\LocationController@showDisabledAreas')->name('admin.view_disabled_areas');
            Route::post('areas', 'Web\LocationController@submitCreateAreaForm')->name('admin.created_area_submit');
            Route::put('areas/{areaId}', 'Web\LocationController@submitAreaEditForm')->name('admin.updated_area_submit');
            Route::delete('areas/{areaId}', 'Web\LocationController@areaDeleteMethod')->name('admin.delete_area');
            Route::patch('areas/{areaId}', 'Web\LocationController@areaUndoMethod')->name('admin.undo_area');



            Route::get('weapons/enabled', 'Web\WeaponController@showEnabledweapons')->name('admin.view_enabled_weapons');
            Route::get('weapons/disabled', 'Web\WeaponController@showDisabledweapons')->name('admin.view_disabled_weapons');
            Route::post('weapons', 'Web\WeaponController@submitCreateWeaponForm')->name('admin.created_weapon_submit');
            Route::put('weapons/{weaponId}', 'Web\WeaponController@submitWeaponEditForm')->name('admin.updated_weapon_submit');
            Route::delete('weapons/{weaponId}', 'Web\WeaponController@weaponDeleteMethod')->name('admin.delete_weapon');
            Route::patch('weapons/{weaponId}', 'Web\WeaponController@weaponUndoMethod')->name('admin.undo_weapon');

            
            Route::get('animations/enabled', 'Web\AnimationController@showEnabledanimations')->name('admin.view_enabled_animations');
            Route::get('animations/disabled', 'Web\AnimationController@showDisabledanimations')->name('admin.view_disabled_animations');
            Route::post('animations', 'Web\AnimationController@submitCreateAnimationForm')->name('admin.created_animation_submit');
            Route::put('animations/{animationId}', 'Web\AnimationController@submitAnimationEditForm')->name('admin.updated_animation_submit');
            Route::delete('animations/{animationId}', 'Web\AnimationController@animationDeleteMethod')->name('admin.delete_animation');
            Route::patch('animations/{characterId}', 'Web\AnimationController@animationUndoMethod')->name('admin.undo_animation');

        
            Route::get('parachutes/enabled', 'Web\ParachuteController@showEnabledParachutes')->name('admin.view_enabled_parachutes');
            Route::get('parachutes/disabled', 'Web\ParachuteController@showDisabledParachutes')->name('admin.view_disabled_parachutes');
            Route::post('parachutes', 'Web\ParachuteController@submitCreateParachuteForm')->name('admin.created_parachute_submit');
            Route::put('parachutes/{parachuteId}', 'Web\ParachuteController@submitParachuteEditForm')->name('admin.updated_parachute_submit');
            Route::delete('parachutes/{parachuteId}', 'Web\ParachuteController@parachuteDeleteMethod')->name('admin.delete_parachute');
            Route::patch('parachutes/{parachuteId}', 'Web\ParachuteController@parachuteUndoMethod')->name('admin.undo_parachute');


            Route::get('reward-types/enabled', 'Web\RewardController@showAllEnabledRewardTypes')->name('admin.view_enabled_reward_types');
            Route::get('reward-types/disabled', 'Web\RewardController@showAllDisabledRewardTypes')->name('admin.view_disabled_reward_types');
            Route::post('reward-types', 'Web\RewardController@submitCreateRewardTypeForm')->name('admin.created_reward_type_submit');
            Route::put('reward-types/{rewardTypeId}', 'Web\RewardController@submitRewardTypeEditForm')->name('admin.updated_reward_type_submit');
            Route::delete('reward-types/{rewardTypeId}', 'Web\RewardController@rewardTypeDeleteMethod')->name('admin.delete_reward_type');
            Route::patch('reward-types/{rewardTypeId}', 'Web\RewardController@rewardTypeUndoMethod')->name('admin.undo_reward_type');


            Route::get('daily-login-rewards/enabled', 'Web\RewardController@showAllEnabledDailyLoginRewards')->name('admin.view_enabled_login_rewards');
            Route::get('daily-login-rewards/disabled', 'Web\RewardController@showAllDisabledDailyLoginRewards')->name('admin.view_disabled_login_rewards');
            Route::post('daily-login-rewards', 'Web\RewardController@submitDailyLoginRewardCreateForm')->name('admin.submit_created_login_rewards');
            Route::put('daily-login-rewards/{rewardTypeId}', 'Web\RewardController@submitDailyLoginRewardEditForm')->name('admin.submit_updated_login_rewards');
            Route::delete('daily-login-rewards/{rewardId}', 'Web\RewardController@deleteDailyLoginReward')->name('admin.delete_login_rewards');
            Route::patch('daily-login-rewards/{rewardId}', 'Web\RewardController@restoreDailyLoginReward')->name('admin.restore_login_rewards');


            Route::get('coin-packs/enabled', 'Web\WealthController@showEnabledCoinPacks')->name('admin.view_enabled_coin_packs');
            Route::get('coin-packs/disabled', 'Web\WealthController@showDisabledCoinPacks')->name('admin.view_disabled_coin_packs');
            Route::post('coin-packs', 'Web\WealthController@submitCreatedCoinPack')->name('admin.created_coin_pack_submit');
            Route::put('coin-packs/{coinPackId}', 'Web\WealthController@submitEditedCoinPack')->name('admin.updated_coin_pack_submit');
            Route::delete('coin-packs/{coinPackId}', 'Web\WealthController@coinPackDeleteMethod')->name('admin.delete_coin_pack');
            Route::patch('coin-packs/{coinPackId}', 'Web\WealthController@CoinPackUndoMethod')->name('admin.undo_coin_pack');


            // Route::get('gem-packs', 'Web\WealthController@showAllGemPacks')->name('admin.view_gem_packs');
            Route::get('gem-packs/enabled', 'Web\WealthController@showEnabledGemPacks')->name('admin.view_enabled_gem_packs');
            Route::get('gem-packs/disabled', 'Web\WealthController@showDisabledGemPacks')->name('admin.view_disabled_gem_packs');
            Route::post('gem-packs', 'Web\WealthController@submitCreatedGemPack')->name('admin.created_gem_pack_submit');
            Route::put('gem-packs/{gemPackId}', 'Web\WealthController@submitEditedGemPack')->name('admin.updated_gem_pack_submit');
            Route::delete('gem-packs/{gemPackId}', 'Web\WealthController@gemPackDeleteMethod')->name('admin.delete_gem_pack');
            Route::patch('gem-packs/{gemPackId}', 'Web\WealthController@gemPackUndoMethod')->name('admin.undo_gem_pack');

            
            Route::get('boost-packs/enabled', 'Web\BoostController@showEnabledBoostPacks')->name('admin.view_enabled_boost_packs');
            Route::get('boost-packs/disabled', 'Web\BoostController@showDisabledBoostPacks')->name('admin.view_disabled_boost_packs');
            Route::post('boost-pack', 'Web\BoostController@submitCreatedBoostPack')->name('admin.created_boost_pack_submit');
            Route::put('boost-packs/{boostPackId}', 'Web\BoostController@submitEditedBoostPack')->name('admin.updated_boost_pack_submit');
            Route::delete('boost-packs/{boostPackId}', 'Web\BoostController@boostPackDeleteMethod')->name('admin.delete_boost_pack');
            Route::patch('boost-packs/{boostPackId}', 'Web\BoostController@boostPackUndoMethod')->name('admin.undo_boost_pack');


            Route::get('bundle-packs/enabled', 'Web\BundleController@showEnabledBundlePacks')->name('admin.view_enabled_bundle_packs');
            Route::get('bundle-packs/disabled', 'Web\BundleController@showDisabledBundlePacks')->name('admin.view_disabled_bundle_packs');
            Route::post('bundle-packs', 'Web\BundleController@submitCreatedBundlePack')->name('admin.created_bundle_pack_submit');
            Route::get('bundle-pack/{bundlePackId}/edit', 'Web\BundleController@showBundlePackEditForm')->name('admin.update_bundle_pack');
            Route::put('bundle-pack/{bundlePackId}', 'Web\BundleController@submitEditedBundlePack')->name('admin.updated_bundle_pack_submit');
            Route::delete('bundle-pack/{bundlePackId}', 'Web\BundleController@bundlePackDeleteMethod')->name('admin.delete_bundle_pack');
            Route::patch('bundle-pack/{bundlePackId}', 'Web\BundleController@bundlePackUndoMethod')->name('admin.undo_bundle_pack');
            

            Route::get('store/all', 'Web\StoreController@showStoreMethod')->name('admin.create_store');
            Route::get('purchase/all', 'Web\StoreController@viewAllPurchases')->name('admin.view_purchase');


            Route::post('image', 'Web\MediaController@submitCreatedImage')->name('admin.created_image_submit');
            Route::get('images/all', 'Web\MediaController@showAllImages')->name('admin.view_images');
            Route::put('image/{imageId}', 'Web\MediaController@submitEditedImage')->name('admin.updated_image_submit');
            Route::delete('image/{imageId}', 'Web\MediaController@imageDeleteMethod')->name('admin.delete_image');


            Route::post('news', 'Web\MediaController@submitCreatedNews')->name('admin.created_news_submit');
            Route::get('news/all', 'Web\MediaController@showAllNews')->name('admin.view_news');
            Route::put('news/{newsId}', 'Web\MediaController@submitEditedNews')->name('admin.updated_news_submit');
            Route::delete('news/{newsId}', 'Web\MediaController@newsDeleteMethod')->name('admin.delete_news');


            Route::post('message', 'Web\MediaController@submitCreatedMessage')->name('admin.created_message_submit');
            Route::get('messages/all', 'Web\MediaController@showAllMessages')->name('admin.view_messages');
            Route::put('messages/{messageId}', 'Web\MediaController@submitEditedMessage')->name('admin.updated_message_submit');
            Route::delete('message/{messageId}', 'Web\MediaController@messageDeleteMethod')->name('admin.delete_message');

            
            Route::get('mission-types/enabled', 'Web\MissionController@showAllEnabledMissionTypes')->name('admin.view_enabled_mission_types');
            Route::get('mission-types/disabled', 'Web\MissionController@showAllDisabledMissionTypes')->name('admin.view_disabled_mission_types');
            Route::post('mission-types', 'Web\MissionController@submitCreateMissionTypeForm')->name('admin.created_mission_type_submit');
            Route::put('mission-types/{missionTypeId}', 'Web\MissionController@submitMissionTypeEditForm')->name('admin.updated_mission_type_submit');
            Route::delete('mission-types/{missionTypeId}', 'Web\MissionController@missionTypeDeleteMethod')->name('admin.delete_mission_type');
            Route::patch('mission-types/{missionTypeId}', 'Web\MissionController@missionTypeUndoMethod')->name('admin.undo_mission_type');


            Route::get('missions/enabled', 'Web\MissionController@showEnabledMissions')->name('admin.view_enabled_missions');
            Route::get('missions/disabled', 'Web\MissionController@showDisabledMissions')->name('admin.view_disabled_missions');
            Route::post('missions', 'Web\MissionController@submitCreateMissionForm')->name('admin.created_mission_submit');
            Route::put('missions/{missionId}', 'Web\MissionController@submitMissionEditForm')->name('admin.updated_mission_submit');
            Route::delete('missions/{missionId}', 'Web\MissionController@missionDeleteMethod')->name('admin.delete_mission');
            Route::patch('missions/{missionId}', 'Web\MissionController@missionUndoMethod')->name('admin.undo_mission');


            Route::get('subscription-packages/enabled', 'Web\SubscriptionController@showEnabledSubscriptionPackages')->name('admin.view_enabled_subscription_packages');
            Route::get('subscription-packages/disabled', 'Web\SubscriptionController@showDisabledSubscriptionPackages')->name('admin.view_disabled_subscription_packages');
            Route::post('subscription-package', 'Web\SubscriptionController@submitCreatedSubscriptionPackageForm')->name('admin.created_subscription_package_submit');
            Route::put('subscription-package/{subscriptionPackageId}', 'Web\SubscriptionController@submitSubscriptionPackageEditForm')->name('admin.updated_subscription_package_submit');
            Route::delete('subscription-package/{subscriptionPackageId}', 'Web\SubscriptionController@subscriptionPackageDeleteMethod')->name('admin.delete_subscription_package');
            Route::patch('subscription-package/{subscriptionPackageId}', 'Web\SubscriptionController@subscriptionPackageUndoMethod')->name('admin.undo_subscription_package');
        });

    });

    Route::get('update', 'Web\AdminController@showUpdateForm')->name('admin.update_quit');
    Route::post('update', 'Web\AdminController@submitUpdateForm')->name('admin.updated_quit_submit');
});