<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 2:52 PM
 */

namespace Ronjune\Steam\Interfaces;

interface IDOTA2Match {

    public function getLeagueListing();

    public function getLiveLeagueGames($league_id, $match_id);

    public function getMatchDetails($match_id);

    public function getMatchHistory($hero_id, $game_mode, $skill, $min_players, $account_id, $league_id, $start_at_match_id, $matches_requested, $tournament_games_only);

    public function getMatchHistoryBySequenceNum($start_at_match_seq_num, $matches_requested);

    public function getScheduledLeagueGames($date_min, $date_max);

    public function getTeamInfoByTeamID($start_at_team_id, $teams_requested);

    public function getTournamentPlayerStats($account_id, $league_id, $hero_id, $time_frame, $match_id);
}
