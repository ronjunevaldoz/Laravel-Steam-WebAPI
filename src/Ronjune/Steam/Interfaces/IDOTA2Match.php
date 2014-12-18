<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 2:52 PM
 */

namespace Ronjune\Steam\Interfaces;

interface IDotA2Match {

    public function getLeagueListing();

    public function getLiveLeagueGames($league_id, $match_id);

    public function getMatchDetails($match_id);

    public function getMatchHistory($options);

    public function getMatchHistoryBySequenceNum($start_at_match_seq_num, $matches_requested);

    public function getScheduledLeagueGames($date_min, $date_max);

    public function getTeamInfoByTeamID($start_at_team_id, $teams_requested);

    public function getTournamentPlayerStats($account_id, $league_id, $hero_id, $time_frame, $match_id);
}
