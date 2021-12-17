<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPokemon(){
        $data = DB::statement('call PokemonSel(-1);');
        return response()->json($data); 
    }

    public function postPokemon(){
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?offset0&limit=150');
        $pokemons = [];
        $data = $response["results"];

        foreach($data as $row => $pokemon){
            array_push($pokemons, $pokemon["name"]);
            $result = DB::select('call PokemonIU(?,?,?)', [-1, $pokemon["name"], $pokemon["url"]]);
        }

        $mensaje = "ok";

        return response()->json($mensaje); 
    }
}