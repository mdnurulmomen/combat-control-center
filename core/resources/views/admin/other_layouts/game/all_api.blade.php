]
@extends('admin.master_layout.app')
@section('contents')

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h3> List Api</h3>
                    </div>
                </div>
                
                <hr>

                <div class="bs-component">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#version1">Version 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#version2">Version 2</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-2" id="myTabContent">
                        <div class="tab-pane fade active show" id="version1">
                            
                            <p class="text-danger">
                                <b>Version One is prefixed with <i>'v1'</i></b>
                            </p>

                            <div class="row">
                                <div class="col-12 table-responsive">
                                    
                                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Api</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Method</th>
                                                <th scope="col">Parameters</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            <tr class="success">
                                                <th scope="row">1</th>
                                                <td>game/version</td>
                                                <td>Check Version</td>
                                                <td>Get</td>
                                                <td>None</td>
                                            </tr>
                                            
                                            <tr class="danger">
                                                <th scope="row">2</th>
                                                <td>user</td>
                                                <td>Create User Or Login</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>connectionType,</span>
                                                    <span>selectedCharacter, </span>
                                                    <span>selectedParachute, </span>
                                                    <span>selectedAnimation, </span>
                                                    <span>selectedWeapon, </span>
                                                    <span>userName,</span>
                                                    <span>mobileNo,</span>
                                                    <span>facebookId / userDeviceId (required),</span>
                                                    <span>facebookName</span>
                                                    <span>userEmail,</span>
                                                    <span>userLocation,</span>
                                                    <span>profilePic,</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">3</th>
                                                <td>player/{playerId}</td>
                                                <td>Player Details</td>
                                                <td>Get</td>
                                                <td>None</td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">4</th>
                                                <td>player</td>
                                                <td>Update User, Player</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required),</span>
                                                    <span>userName,</span>
                                                    <span>mobileNo,</span>
                                                    <span>userEmail,</span>
                                                    <span>userLocation,</span>
                                                    <span>facebookId,</span>
                                                    <span>facebookName,</span>
                                                    <span>profilePic,</span>
                                                    <span>connectionType,</span>
                                                    <span>playerBatch,</span>
                                                    <span>selectedParachute,</span>
                                                    <span>selectedCharacter,</span>
                                                    <span>selectedAnimation,</span>
                                                    <span>selectedWeapon,</span>
                                                    <span>country</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">5</th>
                                                <td>store</td>
                                                <td>Store Details</td>
                                                <td>Get</td>
                                                <td>None</td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">6</th>
                                                <td>store</td>
                                                <td>Purchase</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>itemId (required),</span>
                                                    <span>userId (required),</span>
                                                    <span>gatewayName (required),</span>
                                                    <span>paymentId (required)</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">7</th>
                                                <td>ads</td>
                                                <td>AdUrls</td>
                                                <td>Get</td>
                                                <td>
                                                    None
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">8</th>
                                                <td>game-over</td>
                                                <td>Game Over</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required),</span>
                                                    <span>battleMode,</span>
                                                    <span>coinsGainInCurrentMatch,</span>
                                                    <span>totalOpponentsKilled,</span>
                                                    <span>totalMonsterKilled,</span>
                                                    <span>totalDoubleKills,</span>
                                                    <span>totalTripleKills,</span>
                                                    <span>totalTreasureCollected,</span>
                                                    <span>totalTreasureWon,</span>
                                                    <span>totalGunsCollectedInField, </p>
                                                    <span>totalItemsCollectedInField, </span>
                                                    <span>totalCratesCollected, </span>
                                                    <span>totalAirDropsCollected, </span>
                                                    <span>playerRankInCurrentMatch</span>
                                                    <span>xpGainInCurrentMatch,</span>
                                                    <span>matchStartTime, </span>
                                                    <span>matchPlayDuration (required)</span>
                                                </td>
                                            </tr>


                                            <tr class="info">
                                                <th scope="row">9</th>
                                                <td>match-start</td>
                                                <td>To Start Match</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId(required),</span>
                                                    <span>meleeBooster,</span>
                                                    <span>lightBooster,</span>
                                                    <span>heavyBooster,</span>
                                                    <span>ammoBoost,</span>
                                                    <span>speedBoost,</span>
                                                    <span>armorBoost,</span>
                                                    <span>rangeBoost,</span>
                                                    <span>xpMultiplier</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">10</th>
                                                <td>leaders</td>
                                                <td>Leadership Board</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required)</span>
                                                </td>
                                            </tr>


                                            <tr class="info">
                                                <th scope="row">11</th>
                                                <td>number</td>
                                                <td>Check Blacklist</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>mobileNumber(required), </span>
                                                    <span>block(required)</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">12</th>
                                                <td>assets/update</td>
                                                <td>Update Multiple Assets</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required),</span>
                                                    <span>coinsEarned ,</span>
                                                    <span>gemsEarned ,</span>
                                                    <span>xpMultiplierEarned</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">13</th>
                                                <td>treasure</td>
                                                <td>Treasure Identifier</td>
                                                <td>Get</td>
                                                <td>
                                                    <span>None</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">14</th>
                                                <td>treasure</td>
                                                <td>Player Treasure List</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId(required)</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">15</th>
                                                <td>treasure/redemption</td>
                                                <td>Treasure Redemption</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>serial (required),</span>
                                                    <span>userId (required),</span>
                                                    <span>treasureId (required),</span>
                                                    <span>playerPhone,</span>
                                                    <span>agentPhone,</span>
                                                    <span>exchangingType (coins,gems,MB,TalkTime,talkTime,talktime)</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="version2">
                            <p class="text-danger">
                                <b>Version Two is prefixed with <i>'v2'</i> . JWT is enabled with <i>'v2'</i>.</b>
                            </p>

                            <div class="row">
                                <div class="col-12 table-responsive">
                                    
                                    <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Api</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Method</th>
                                                <th scope="col">Parameters</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            <tr class="success">
                                                <th scope="row">1</th>
                                                <td>game/version</td>
                                                <td>Check Version</td>
                                                <td>Get</td>
                                                <td>None</td>
                                            </tr>
                                            
                                            <tr class="danger">
                                                <th scope="row">2</th>
                                                <td>user</td>
                                                <td>Create User Or Login</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>connectionType,</span>
                                                    <span>selectedCharacter, </span>
                                                    <span>selectedParachute, </span>
                                                    <span>selectedAnimation, </span>
                                                    <span>selectedWeapon, </span>
                                                    <span>userName,</span>
                                                    <span>mobileNo,</span>
                                                    <span>facebookId / userDeviceId (required),</span>
                                                    <span>facebookName</span>
                                                    <span>userEmail,</span>
                                                    <span>userLocation,</span>
                                                    <span>profilePic,</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">3</th>
                                                <td>player/show</td>
                                                <td>Player Details</td>
                                                <td>Post</td>
                                                <td>userId (Required)</td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">4</th>
                                                <td>player</td>
                                                <td>Update User, Player</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required),</span>
                                                    <span>userName,</span>
                                                    <span>mobileNo,</span>
                                                    <span>userEmail,</span>
                                                    <span>userLocation,</span>
                                                    <span>facebookId,</span>
                                                    <span>facebookName,</span>
                                                    <span>profilePic,</span>
                                                    <span>connectionType,</span>
                                                    <span>playerBatch,</span>
                                                    <span>selectedParachute,</span>
                                                    <span>selectedCharacter,</span>
                                                    <span>selectedAnimation,</span>
                                                    <span>selectedWeapon,</span>
                                                    <span>country</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">5</th>
                                                <td>store</td>
                                                <td>Store Details</td>
                                                <td>Get</td>
                                                <td>None</td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">6</th>
                                                <td>store</td>
                                                <td>Purchase</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>itemId (required),</span>
                                                    <span>userId (required),</span>
                                                    <span>gatewayName (required),</span>
                                                    <span>paymentId (required)</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">7</th>
                                                <td>ads</td>
                                                <td>AdUrls</td>
                                                <td>Get</td>
                                                <td>
                                                    None
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">8</th>
                                                <td>game-over</td>
                                                <td>Game Over</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required),</span>
                                                    <span>battleMode,</span>
                                                    <span>coinsGainInCurrentMatch,</span>
                                                    <span>totalOpponentsKilled,</span>
                                                    <span>totalMonsterKilled,</span>
                                                    <span>totalDoubleKills,</span>
                                                    <span>totalTripleKills,</span>
                                                    <span>totalTreasureCollected,</span>
                                                    <span>totalTreasureWon,</span>
                                                    <span>totalGunsCollectedInField, </p>
                                                    <span>totalItemsCollectedInField, </span>
                                                    <span>totalCratesCollected, </span>
                                                    <span>totalAirDropsCollected, </span>
                                                    <span>playerRankInCurrentMatch</span>
                                                    <span>xpGainInCurrentMatch,</span>
                                                    <span>matchStartTime, </span>
                                                    <span>matchPlayDuration (required)</span>
                                                </td>
                                            </tr>


                                            <tr class="info">
                                                <th scope="row">9</th>
                                                <td>match-start</td>
                                                <td>To Start Match</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId(required),</span>
                                                    <span>meleeBooster,</span>
                                                    <span>lightBooster,</span>
                                                    <span>heavyBooster,</span>
                                                    <span>ammoBoost,</span>
                                                    <span>speedBoost,</span>
                                                    <span>armorBoost,</span>
                                                    <span>rangeBoost,</span>
                                                    <span>xpMultiplier</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">10</th>
                                                <td>leaders</td>
                                                <td>Leadership Board</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required)</span>
                                                </td>
                                            </tr>


                                            <tr class="info">
                                                <th scope="row">11</th>
                                                <td>number</td>
                                                <td>Check Blacklist</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>mobileNumber(required), </span>
                                                    <span>block(required)</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">12</th>
                                                <td>assets/update</td>
                                                <td>Update Multiple Assets</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId (required),</span>
                                                    <span>coinsEarned ,</span>
                                                    <span>gemsEarned ,</span>
                                                    <span>xpMultiplierEarned</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">13</th>
                                                <td>treasure</td>
                                                <td>Treasure Identifier</td>
                                                <td>Get</td>
                                                <td>
                                                    <span>None</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">14</th>
                                                <td>treasure</td>
                                                <td>Player Treasure List</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>userId(required)</span>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <th scope="row">15</th>
                                                <td>treasure/redemption</td>
                                                <td>Treasure Redemption</td>
                                                <td>Post</td>
                                                <td>
                                                    <span>serial (required),</span>
                                                    <span>userId (required),</span>
                                                    <span>treasureId (required),</span>
                                                    <span>playerPhone,</span>
                                                    <span>agentPhone,</span>
                                                    <span>exchangingType (coins,gems,MB,TalkTime,talkTime,talktime)</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
@stop