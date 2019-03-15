<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserCon extends Controller
{
    public function index(){
        $query = User::all();
        $users = self::getQuery('all_users', 2, $query);

        return view('welcome', compact('users'));
    }

    public static function getQuery($cache_key, $timeInMinutes, $query){
        // NOTE: 
            // in the first load of page the return User::all() query will run down here  
            // And the second load of the page will run the query from stored cache named (all_users) and it will refresh every after 2minutes
        
                                //  cache_key_word,  timer, function callback
            return cache()->remember($cache_key, Carbon::now()->addMinutes($timeInMinutes), function() use($query){ // the use() function is get the query outside the scope
            return $query; 
        });
    }
}
