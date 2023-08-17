<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;

Route::get('/', [AdminController::class, 'index']);

Route::group(['prefix'=>'admin', 'middleware'=>'web'], function (){

    Route::group(['middleware'=>'guest:admin'], function ()
    {
        Route::get('/', [AdminController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/', [AdminController::class, 'login'])->name('admin.login_submit');
    });

    Route::group(['middleware'=>['verified.OTP']], function ()
    {
        Route::get('email-otp', [AdminController::class, 'showOTP'])->name('admin.otp');
        Route::get('resend-email-otp/{adminId}', [AdminController::class, 'generateNewOTPToken'])->name('admin.generate_new_otp_code');
        Route::post('email-otp', [AdminController::class, 'submitOTPCode'])->name('admin.submit_otp_code');
    });

    Route::group(['middleware'=>'auth:admin'], function ()
    {
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::group(['middleware'=>'check.OTP'], function ()
        {
            Route::get('home', [AdminController::class, 'homeMethod'])->name('admin.home');

            Route::get('profile', [AdminController::class, 'showProfileForm'])->name('admin.update_profile');
            Route::put('profile', [AdminController::class, 'submitProfileForm'])->name('admin.updated_profile_submit');
            Route::get('password', [AdminController::class, 'showPasswordForm'])->name('admin.update_password');
            Route::post('password', [AdminController::class, 'submitPasswordForm'])->name('admin.updated_password_submit');


            Route::group(['middleware' => ['permission:analytic']], function () {

                Route::get('analytics-talktime', [AdminController::class, 'showTalktimeAnalytics'])->name('admin.show_talktime_analytics');

                Route::get('analytics-earnings', [AdminController::class, 'showEarningAnalytics'])->name('admin.show_earnings_analytics');

                Route::get('analytics-treasures', [AdminController::class, 'showTreasureAnalytics'])->name('admin.show_treasures_analytics');

                Route::get('analytics-gemPacks', [AdminController::class, 'showGemPacksAnalytics'])->name('admin.show_gem_packs_analytics');

                Route::get('analytics-purchase', [AdminController::class, 'showPurchaseAnalytics'])->name('admin.show_purchase_analytics');
            });


            Route::group(['middleware' => ['permission:setting']], function () {

                Route::get('settings/cms', [AdminController::class, 'showAdminSettingsForm'])->name('admin.settings_admin_panel');
                Route::put('settings/cms', [AdminController::class, 'submitAdminSettingsForm'])->name('admin.settings_admin_panel_submit');
            });


            Route::post('users', [AdminController::class, 'submitCreateUserForm'])->name('admin.created_user_submit');
            Route::get('users', [AdminController::class, 'showAllUsers'])->name('admin.view_users');
            Route::put('users/{userId}', [AdminController::class, 'submitUserEditForm'])->name('admin.updated_user_submit');
            Route::delete('users/{userId}', [AdminController::class, 'userDeleteMethod'])->name('admin.delete_user');


            Route::get('api', [AdminController::class, 'showAllApi'])->name('admin.view_api');

            Route::group(['middleware' => ['permission:setting']], function () {

                Route::get('game/settings', [GameController::class, 'showGameSettingsForm'])->name('admin.settings_game');
                Route::put('game/settings', [GameController::class, 'submitGameSettingsForm'])->name('admin.settings_game_submit');


                Route::get('rules/settings', [GameController::class, 'showRulesSettingsForm'])->name('admin.settings_rules');
                Route::put('rules/settings', [GameController::class, 'submitRulesSettingsForm'])->name('admin.settings_rules_submit');


                Route::get('gift-treasures', [GiftController::class, 'showTreasureSettingsForm'])->name('admin.settings_gift_treasure');
                Route::put('gift-treasures', [GiftController::class, 'submitTreasureSettingsForm'])->name('admin.settings_gift_treasure_submit');


                Route::get('gift-animations', [GiftController::class, 'showGiftAnimations'])->name('admin.settings_gift_animations');
                Route::put('gift-animations', [GiftController::class, 'submitGiftAnimations'])->name('admin.settings_gift_animations_submit');


                Route::get('gift-boostpacks', [GiftController::class, 'showGiftBoostPacks'])->name('admin.settings_gift_boost_packs');
                Route::put('gift-boostpacks', [GiftController::class, 'submitGiftBoostPacks'])->name('admin.settings_gift_boost_packs_submit');


                Route::get('gift-characters', [GiftController::class, 'showGiftCharacters'])->name('admin.setting_gift_characters');
                Route::put('gift-characters', [GiftController::class, 'submitGiftCharacters'])->name('admin.setting_gift_characters_submit');


                Route::get('gift-parachutes', [GiftController::class, 'showGiftParachutes'])->name('admin.setting_gift_parachutes');
                Route::put('gift-parachutes', [GiftController::class, 'submitGiftParachutes'])->name('admin.setting_gift_parachutes_submit');


                Route::get('gift-weapons', [GiftController::class, 'showGiftWeapons'])->name('admin.setting_gift_weapons');
                Route::put('gift-weapons', [GiftController::class, 'submitGiftWeapons'])->name('admin.setting_gift_weapons_submit');


                Route::get('gift-points', [GiftController::class, 'showGiftPoints'])->name('admin.setting_gift_points');
                Route::put('gift-points', [GiftController::class, 'submitGiftPoints'])->name('admin.setting_gift_points_submit');
            });



            Route::get('players', [PlayerController::class, 'showAllPlayers'])->name('admin.view_players');
            Route::put('players/{playerId}/', [PlayerController::class, 'submitPlayerEditForm'])->name('admin.updated_player_submit');
            Route::delete('players/{playerId}', [PlayerController::class, 'deletePlayerMethod'])->name('admin.delete_player');


            Route::get('bots', [PlayerController::class, 'showAllBots'])->name('admin.view_bots');
            Route::post('bots', [PlayerController::class, 'submitCreateBotForm'])->name('admin.created_bot_submit');

            Route::put('bot/{botId}/', [PlayerController::class, 'submitBotEditForm'])->name('admin.updated_bot_submit');

            Route::get('leaderboard', [PlayerController::class, 'showLeaderboard'])->name('admin.view_leaderboard');
            Route::delete('bot/{botId}', [PlayerController::class, 'deleteBotMethod'])->name('admin.delete_bot');


            Route::get('characters/enabled', [CharacterController::class, 'showEnabledCharacters'])->name('admin.view_enabled_characters');
            Route::get('characters/disabled', [CharacterController::class, 'showDisabledCharacters'])->name('admin.view_disabled_characters');
            Route::post('characters', [CharacterController::class, 'submitCreateCharacterForm'])->name('admin.created_character_submit');
            Route::patch('characters/{characterId}', [CharacterController::class, 'characterUndoMethod'])->name('admin.undo_character');
            Route::put('characters/{characterId}', [CharacterController::class, 'submitCharacterEditForm'])->name('admin.updated_character_submit');
            Route::delete('character/{characterId}', [CharacterController::class, 'characterDeleteMethod'])->name('admin.delete_character');


            Route::get('black-lists', [BlackListController::class, 'showBlackList'])->name('admin.view_black_list');
            Route::post('black-lists', [BlackListController::class, 'addNewBlackListNumber'])->name('admin.create_black_list_number');
            Route::delete('black-lists/{blackListId}', [BlackListController::class, 'deleteBlackListedNumber'])->name('admin.delete_black_listed_number');


            Route::get('treasure-types/enabled', [TreasureController::class, 'showAllEnabledTreasureTypes'])->name('admin.view_enabled_treasure_types');
            Route::get('treasure-types/disabled', [TreasureController::class, 'showAllDisabledTreasureTypes'])->name('admin.view_disabled_treasure_types');
            Route::post('treasure-types', [TreasureController::class, 'submitCreateTreasureTypeForm'])->name('admin.created_treasure_type_submit');
            Route::put('treasure-types/{treasureTypeId}', [TreasureController::class, 'submitTreasureTypeEditForm'])->name('admin.updated_treasure_type_submit');
            Route::delete('treasure-types/{treasureTypeId}', [TreasureController::class, 'treasureTypeDeleteMethod'])->name('admin.delete_treasure_type');
            Route::patch('treasure-types/{treasureTypeId}', [TreasureController::class, 'treasureTypeUndoMethod'])->name('admin.undo_treasure_type');


            Route::get('treasures/enabled', [TreasureController::class, 'showEnabledTreasures'])->name('admin.view_enabled_treasures');
            Route::get('treasures/disabled', [TreasureController::class, 'showDisabledTreasures'])->name('admin.view_disabled_treasures');
            Route::post('treasures', [TreasureController::class, 'submitCreateTreasureForm'])->name('admin.created_treasure_submit');
            Route::put('treasures/{treasureId}', [TreasureController::class, 'submitTreasureEditForm'])->name('admin.updated_treasure_submit');
            Route::delete('treasures/{treasureId}', [TreasureController::class, 'treasureDeleteMethod'])->name('admin.delete_treasure');
            Route::patch('treasures/{treasureId}', [TreasureController::class, 'treasureUndoMethod'])->name('admin.undo_treasure');


            Route::get('treasures-gifted', [TreasureController::class, 'showAllTreasureGifted'])->name('admin.view_treasure_gifted');
            Route::get('treasures-redeemed', [TreasureController::class, 'showAllTreasureRedeemed'])->name('admin.view_treasure_redeems');


            Route::get('treasures/requested', [TreasureController::class, 'showTreasureRequested'])->name('admin.show_treasure_requested');
            Route::post('talkTime/confirmed', [TreasureController::class, 'confirmTreasureRequested'])->name('admin.confirm_treasure_requested');


            Route::get('vendors/enabled', [VendorController::class, 'showEnabledVendors'])->name('admin.view_enabled_vendors');
            Route::get('vendors/disabled', [VendorController::class, 'showDisabledVendors'])->name('admin.view_disabled_vendors');
            Route::post('vendors', [VendorController::class, 'submitCreateVendorForm'])->name('admin.created_vendor_submit');
            Route::put('vendors/{vendorId}', [VendorController::class, 'submitVendorEditForm'])->name('admin.updated_vendor_submit');
            Route::delete('vendors/{vendorId}', [VendorController::class, 'vendorDeleteMethod'])->name('admin.delete_vendor');
            Route::patch('vendors/{vendorId}', [VendorController::class, 'vendorUndoMethod'])->name('admin.undo_vendor');

            Route::get('cities/enabled', [LocationController::class, 'showEnabledCities'])->name('admin.view_enabled_cities');
            Route::get('cities/disabled', [LocationController::class, 'showDisabledCities'])->name('admin.view_disabled_cities');
            Route::post('cities', [LocationController::class, 'submitCreateCityForm'])->name('admin.created_city_submit');
            Route::put('cities/{cityId}', [LocationController::class, 'submitCityEditForm'])->name('admin.updated_city_submit');
            Route::delete('cities/{cityId}', [LocationController::class, 'cityDeleteMethod'])->name('admin.delete_city');
            Route::patch('cities/{cityId}', [LocationController::class, 'cityUndoMethod'])->name('admin.undo_city');


            Route::get('areas/enabled', [LocationController::class, 'showEnabledAreas'])->name('admin.view_enabled_areas');
            Route::get('areas/disabled', [LocationController::class, 'showDisabledAreas'])->name('admin.view_disabled_areas');
            Route::post('areas', [LocationController::class, 'submitCreateAreaForm'])->name('admin.created_area_submit');
            Route::put('areas/{areaId}', [LocationController::class, 'submitAreaEditForm'])->name('admin.updated_area_submit');
            Route::delete('areas/{areaId}', [LocationController::class, 'areaDeleteMethod'])->name('admin.delete_area');
            Route::patch('areas/{areaId}', [LocationController::class, 'areaUndoMethod'])->name('admin.undo_area');



            Route::get('weapons/enabled', [WeaponController::class, 'showEnabledweapons'])->name('admin.view_enabled_weapons');
            Route::get('weapons/disabled', [WeaponController::class, 'showDisabledweapons'])->name('admin.view_disabled_weapons');
            Route::post('weapons', [WeaponController::class, 'submitCreateWeaponForm'])->name('admin.created_weapon_submit');
            Route::put('weapons/{weaponId}', [WeaponController::class, 'submitWeaponEditForm'])->name('admin.updated_weapon_submit');
            Route::delete('weapons/{weaponId}', [WeaponController::class, 'weaponDeleteMethod'])->name('admin.delete_weapon');
            Route::patch('weapons/{weaponId}', [WeaponController::class, 'weaponUndoMethod'])->name('admin.undo_weapon');


            Route::get('animations/enabled', [AnimationController::class, 'showEnabledanimations'])->name('admin.view_enabled_animations');
            Route::get('animations/disabled', [AnimationController::class, 'showDisabledanimations'])->name('admin.view_disabled_animations');
            Route::post('animations', [AnimationController::class, 'submitCreateAnimationForm'])->name('admin.created_animation_submit');
            Route::put('animations/{animationId}', [AnimationController::class, 'submitAnimationEditForm'])->name('admin.updated_animation_submit');
            Route::delete('animations/{animationId}', [AnimationController::class, 'animationDeleteMethod'])->name('admin.delete_animation');
            Route::patch('animations/{characterId}', [AnimationController::class, 'animationUndoMethod'])->name('admin.undo_animation');


            Route::get('parachutes/enabled', [ParachuteController::class, 'showEnabledParachutes'])->name('admin.view_enabled_parachutes');
            Route::get('parachutes/disabled', [ParachuteController::class, 'showDisabledParachutes'])->name('admin.view_disabled_parachutes');
            Route::post('parachutes', [ParachuteController::class, 'submitCreateParachuteForm'])->name('admin.created_parachute_submit');
            Route::put('parachutes/{parachuteId}', [ParachuteController::class, 'submitParachuteEditForm'])->name('admin.updated_parachute_submit');
            Route::delete('parachutes/{parachuteId}', [ParachuteController::class, 'parachuteDeleteMethod'])->name('admin.delete_parachute');
            Route::patch('parachutes/{parachuteId}', [ParachuteController::class, 'parachuteUndoMethod'])->name('admin.undo_parachute');


            Route::get('reward-types/enabled', [RewardController::class, 'showAllEnabledRewardTypes'])->name('admin.view_enabled_reward_types');
            Route::get('reward-types/disabled', [RewardController::class, 'showAllDisabledRewardTypes'])->name('admin.view_disabled_reward_types');
            Route::post('reward-types', [RewardController::class, 'submitCreateRewardTypeForm'])->name('admin.created_reward_type_submit');
            Route::put('reward-types/{rewardTypeId}', [RewardController::class, 'submitRewardTypeEditForm'])->name('admin.updated_reward_type_submit');
            Route::delete('reward-types/{rewardTypeId}', [RewardController::class, 'rewardTypeDeleteMethod'])->name('admin.delete_reward_type');
            Route::patch('reward-types/{rewardTypeId}', [RewardController::class, 'rewardTypeUndoMethod'])->name('admin.undo_reward_type');


            Route::get('daily-login-rewards/enabled', [RewardController::class, 'showAllEnabledDailyLoginRewards'])->name('admin.view_enabled_login_rewards');
            Route::get('daily-login-rewards/disabled', [RewardController::class, 'showAllDisabledDailyLoginRewards'])->name('admin.view_disabled_login_rewards');
            Route::post('daily-login-rewards', [RewardController::class, 'submitDailyLoginRewardCreateForm'])->name('admin.submit_created_login_rewards');
            Route::put('daily-login-rewards/{rewardTypeId}', [GameController::class, 'submitDailyLoginRewardEditForm'])->name('admin.submit_updated_login_rewards');
            Route::delete('daily-login-rewards/{rewardId}', [RewardController::class, 'deleteDailyLoginReward'])->name('admin.delete_login_rewards');
            Route::patch('daily-login-rewards/{rewardId}', [RewardController::class, 'restoreDailyLoginReward'])->name('admin.restore_login_rewards');


            Route::get('coin-packs/enabled', [WealthController::class, 'showEnabledCoinPacks'])->name('admin.view_enabled_coin_packs');
            Route::get('coin-packs/disabled', [WealthController::class, 'showDisabledCoinPacks'])->name('admin.view_disabled_coin_packs');
            Route::post('coin-packs', [WealthController::class, 'submitCreatedCoinPack'])->name('admin.created_coin_pack_submit');
            Route::put('coin-packs/{coinPackId}', [WealthController::class, 'submitEditedCoinPack'])->name('admin.updated_coin_pack_submit');
            Route::delete('coin-packs/{coinPackId}', [WealthController::class, 'coinPackDeleteMethod'])->name('admin.delete_coin_pack');
            Route::patch('coin-packs/{coinPackId}', [WealthController::class, 'CoinPackUndoMethod'])->name('admin.undo_coin_pack');


            // Route::get('gem-packs', 'Web\WealthController@showAllGemPacks')->name('admin.view_gem_packs');
            Route::get('gem-packs/enabled', [WealthController::class, 'showEnabledGemPacks'])->name('admin.view_enabled_gem_packs');
            Route::get('gem-packs/disabled', [WealthController::class, 'showDisabledGemPacks'])->name('admin.view_disabled_gem_packs');
            Route::post('gem-packs', [WealthController::class, 'submitCreatedGemPack'])->name('admin.created_gem_pack_submit');
            Route::put('gem-packs/{gemPackId}', [WealthController::class, 'submitEditedGemPack'])->name('admin.updated_gem_pack_submit');
            Route::delete('gem-packs/{gemPackId}', [WealthController::class, 'gemPackDeleteMethod'])->name('admin.delete_gem_pack');
            Route::patch('gem-packs/{gemPackId}', [WealthController::class, 'gemPackUndoMethod'])->name('admin.undo_gem_pack');


            Route::get('boost-packs/enabled', [BoostController::class, 'showEnabledBoostPacks'])->name('admin.view_enabled_boost_packs');
            Route::get('boost-packs/disabled', [BoostController::class, 'showDisabledBoostPacks'])->name('admin.view_disabled_boost_packs');
            Route::post('boost-pack', [BoostController::class, 'submitCreatedBoostPack'])->name('admin.created_boost_pack_submit');
            Route::put('boost-packs/{boostPackId}', [BoostController::class, 'submitEditedBoostPack'])->name('admin.updated_boost_pack_submit');
            Route::delete('boost-packs/{boostPackId}', [BoostController::class, 'boostPackDeleteMethod'])->name('admin.delete_boost_pack');
            Route::patch('boost-packs/{boostPackId}', [BoostController::class, 'boostPackUndoMethod'])->name('admin.undo_boost_pack');


            Route::get('bundle-packs/enabled', [BundleController::class, 'showEnabledBundlePacks'])->name('admin.view_enabled_bundle_packs');
            Route::get('bundle-packs/disabled', [BundleController::class, 'showDisabledBundlePacks'])->name('admin.view_disabled_bundle_packs');
            Route::post('bundle-packs', [BundleController::class, 'submitCreatedBundlePack'])->name('admin.created_bundle_pack_submit');
            Route::get('bundle-pack/{bundlePackId}/edit', [BundleController::class, 'showBundlePackEditForm'])->name('admin.update_bundle_pack');
            Route::put('bundle-pack/{bundlePackId}', [BundleController::class, 'submitEditedBundlePack'])->name('admin.updated_bundle_pack_submit');
            Route::delete('bundle-pack/{bundlePackId}', [BundleController::class, 'bundlePackDeleteMethod'])->name('admin.delete_bundle_pack');
            Route::patch('bundle-pack/{bundlePackId}', [BundleController::class, 'bundlePackUndoMethod'])->name('admin.undo_bundle_pack');


            Route::get('store', [StoreController::class, 'showStoreMethod'])->name('admin.create_store');
            Route::get('purchase', [StoreController::class, 'viewAllPurchases'])->name('admin.view_purchase');


            Route::post('campaigns', [MediaController::class, 'submitCreatedCampaign'])->name('admin.created_campaign_submit');
            Route::get('campaigns-enabled', [MediaController::class, 'showAllCampaigns'])->name('admin.view_campaigns');
            Route::get('campaigns-diabled', [MediaController::class, 'showAllDisabledCampaigns'])->name('admin.view_disabled_campaigns');
            Route::post('campaign-category-images', [MediaController::class, 'showCampaignCategoryImages'])->name('admin.campaign_category_images');
            Route::put('campaigns/{campaignId}', [MediaController::class, 'submitEditedCampaign'])->name('admin.updated_campaign_submit');
            Route::delete('campaigns/{campaignId}', [MediaController::class, 'campaignDeleteMethod'])->name('admin.delete_campaign');
            Route::patch('campaigns/{campaignId}', [MediaController::class, 'campaignRestoreMethod'])->name('admin.restore_campaign');

            Route::post('campaign-image-categories', [MediaController::class, 'submitCreatedCampaignImageCategory'])->name('admin.created_campaign_image_category_submit');
            Route::get('campaign-image-categories', [MediaController::class, 'showAllEnabledCampaignImageCategoies'])->name('admin.view_enabled_campaign_image_categories');
            Route::get('campaign-image-categories-disabled', [MediaController::class, 'showAllDisabledCampaignImageCategoies'])->name('admin.view_disabled_campaign_image_categories');
            Route::put('campaign-image-categories/{campaignCategoryId}', [MediaController::class, 'submitEditedCampaignImageCategory'])->name('admin.updated_campaign_image_category_submit');
            Route::delete('campaign-image-categories/{campaignCategoryId}', [MediaController::class, 'campaignImageCategoryDeleteMethod'])->name('admin.delete_campaign_image_category');
            Route::patch('campaign-image-categories/{campaignCategoryId}', [MediaController::class, 'campaignImageCategoryRestoreMethod'])->name('admin.restore_campaign_image_category');


            Route::post('news', [MediaController::class, 'submitCreatedNews'])->name('admin.created_news_submit');
            Route::get('news', [MediaController::class, 'showAllNews'])->name('admin.view_news');
            Route::put('news/{newsId}', [MediaController::class, 'submitEditedNews'])->name('admin.updated_news_submit');
            Route::delete('news/{newsId}', [MediaController::class, 'newsDeleteMethod'])->name('admin.delete_news');


            Route::post('message', [MediaController::class, 'submitCreatedMessage'])->name('admin.created_message_submit');
            Route::get('messages', [MediaController::class, 'showAllMessages'])->name('admin.view_messages');
            Route::put('messages/{messageId}', [MediaController::class, 'submitEditedMessage'])->name('admin.updated_message_submit');
            Route::delete('messages/{messageId}', [MediaController::class, 'messageDeleteMethod'])->name('admin.delete_message');


            Route::get('mission-types/enabled', [MissionController::class, 'showAllEnabledMissionTypes'])->name('admin.view_enabled_mission_types');
            Route::get('mission-types/disabled', [MissionController::class, 'showAllDisabledMissionTypes'])->name('admin.view_disabled_mission_types');
            Route::post('mission-types', [MissionController::class, 'submitCreateMissionTypeForm'])->name('admin.created_mission_type_submit');
            Route::put('mission-types/{missionTypeId}', [MissionController::class, 'submitMissionTypeEditForm'])->name('admin.updated_mission_type_submit');
            Route::delete('mission-types/{missionTypeId}', [MissionController::class, 'missionTypeDeleteMethod'])->name('admin.delete_mission_type');
            Route::patch('mission-types/{missionTypeId}', [MissionController::class, 'missionTypeUndoMethod'])->name('admin.undo_mission_type');


            Route::get('missions/enabled', [MissionController::class, 'showEnabledMissions'])->name('admin.view_enabled_missions');
            Route::get('missions/disabled', [MissionController::class, 'showDisabledMissions'])->name('admin.view_disabled_missions');
            Route::post('missions', [MissionController::class, 'submitCreateMissionForm'])->name('admin.created_mission_submit');
            Route::put('missions/{missionId}', [MissionController::class, 'submitMissionEditForm'])->name('admin.updated_mission_submit');
            Route::delete('missions/{missionId}', [MissionController::class, 'missionDeleteMethod'])->name('admin.delete_mission');
            Route::patch('missions/{missionId}', [MissionController::class, 'missionUndoMethod'])->name('admin.undo_mission');


            Route::get('subscription-packages/enabled', [SubscriptionController::class, 'showEnabledSubscriptionPackages'])->name('admin.view_enabled_subscription_packages');
            Route::get('subscription-packages/disabled', [SubscriptionController::class, 'showDisabledSubscriptionPackages'])->name('admin.view_disabled_subscription_packages');
            Route::post('subscription-package', [SubscriptionController::class, 'submitCreatedSubscriptionPackageForm'])->name('admin.created_subscription_package_submit');
            Route::put('subscription-package/{subscriptionPackageId}', [SubscriptionController::class, 'submitSubscriptionPackageEditForm'])->name('admin.updated_subscription_package_submit');
            Route::delete('subscription-package/{subscriptionPackageId}', [SubscriptionController::class, 'subscriptionPackageDeleteMethod'])->name('admin.delete_subscription_package');
            Route::patch('subscription-package/{subscriptionPackageId}', [SubscriptionController::class, 'subscriptionPackageUndoMethod'])->name('admin.undo_subscription_package');
        });

    });

    // Route::get('update', 'Web\AdminController@showUpdateForm')->name('admin.update_quit');
    // Route::post('update', 'Web\AdminController@submitUpdateForm')->name('admin.updated_quit_submit');
});
