<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IDOTA2Match
 *
 * @author R0N
 */

namespace Ronjune\Steam\Services\DotA2;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\IDOTA2Match;

class DotA2Match extends SteamWebAPI implements IDOTA2Match {

    const APPID = 570;

    public function __construct() {
        parent::__construct();
        $this->setInterface('IDOTA2Match_' . self::APPID);
    }

    public function getLeagueListing() {
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->get();
        return is_object($request) ? $request->result->leagues : null;
    }

    public function getLiveLeagueGames($league_id = '', $match_id = '') {
        $parameters = [
            'league_id' => $league_id,
            'match_id' => $match_id
        ];
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
                        
        return is_object($request) && $request->result->status == 200 ? $request->result->games : null;
    }

    public function getMatchDetails($match_id = '') {
        $parameters = [
            'match_id' => $match_id
        ];
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
        return is_object($request) ? $request->result : null;
    }

//          hero_id (Optional) (uint32)
//          A list of hero IDs can be found via the GetHeroes method.
//          game_mode (Optional) (uint32)
//          0 - None
//          1 - All Pick
//          2 - Captain's Mode
//          3 - Random Draft
//          4 - Single Draft
//          5 - All Random
//          6 - Intro
//          7 - Diretide
//          8 - Reverse Captain's Mode
//          9 - The Greeviling
//          10 - Tutorial
//          11 - Mid Only
//          12 - Least Played
//          13 - New Player Pool
//          14 - Compendium Matchmaking
//          16 - Captain's Draft
//          skill (Optional) (uint32)
//          Skill bracket for the matches (Ignored if an account ID is specified).
//          0 - Any
//          1 - Normal
//          2 - High
//          3 - Very High
//          date_min (Optional) (uint32)
//          Minimum date range for returned matches (unix timestamp, rounded to the nearest day).
//          date_max (Optional) (uint32)
//          Maximum date range for returned matches (unix timestamp, rounded to the nearest day).
//          min_players (Optional) (string)
//          Minimum amount of players in a match for the match to be returned.
//          account_id (Optional) (string)
//          32-bit account ID.
//          league_id (Optional) (string)
//          Only return matches from this league. A list of league IDs can be found via the GetLeagueListing method.
//          start_at_match_id (Optional) (string)
//          Start searching for matches equal to or older than this match ID.
//          matches_requested (Optional) (string)
//          Amount of matches to include in results (default: 25).
//          tournament_games_only (Optional) (string)
//          Whether to limit results to tournament matches.
    public function getMatchHistory($hero_id = '', $game_mode = '', $skill = '', $min_players = '', $account_id = '', $league_id = '', $start_at_match_id = '', $matches_requested = '', $tournament_games_only = '1') {
        $parameters = [
//            'date_min' => $yesterday,
//            'date_max' => $tomorrow,
            'hero_id' => $hero_id,
            'game_mode' => $game_mode,
            'skill' => $skill,
            'min_players' => $min_players,
            'account_id' => $account_id,
            'league_id' => $league_id,
            'start_at_match_id' => $start_at_match_id,
            'matches_requested' => $matches_requested,
            'tournament_games_only' => $tournament_games_only,
        ];
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
        return is_object($request) ? $request->result : null;
    }

    public function getMatchHistoryBySequenceNum($start_at_match_seq_num='', $matches_requested='') {
        $parameters = [
            'start_at_match_seq_num' => $start_at_match_seq_num, 
            'matches_requested' => $matches_requested
        ]; 
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
        return is_object($request) ? $request->result : null;
    }

    public function getScheduledLeagueGames($date_min = '', $date_max = '') {
        $parameters = [
            'date_min' => $date_min,
            'date_max' => $date_max
        ];
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
        return is_object($request) ? $request->result->games : null;
    }

    public function getTeamInfoByTeamID($start_at_team_id = '', $teams_requested = '') {
        $parameters = [
            'start_at_team_id' => $start_at_team_id,
            'teams_requested' => $teams_requested
        ];
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
        return is_object($request) && $request->result->status == 1 ? $request->result->teams : null;
    }

    public function getTournamentPlayerStats($account_id = '', $league_id = '', $hero_id = '', $time_frame = '', $match_id = '') {
        $parameters = [
        ];
        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();
        return is_object($request) ? $request : null;
    }

}
