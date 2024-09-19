<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class ChallengesController extends Controller
{
    /**
     * Function to get all active challenges
     * Only the challenges, that are added by the authenticated user, will be visible
     */

    public function getAllActiveChallenges(){
        $user = auth()->user();
        $userChallenges = DB::table('challenges')->where('userid', $user['id'])->where('finished', 0)->get();
        return $userChallenges;
    }

    /**
     * Function to get all finished challenges
     * Only the challenges, that are added by the authenticated user, will be visible
     */

    public function getAllFinishedChallenges(){
        $user = auth()->user();
        $userChallenges = DB::table('challenges')->where('userid', $user['id'])->where('finished', 1)->get();
        return $userChallenges;
    }

    /**
     * Function to get specific challenge.
     * Specified by a challengeid.
     */

    public function getChallengeByID($challengeid){
        $challenge = DB::table('challenges')->where('id', $challengeid)->first();
        return $challenge;
    }

    /**
     * Function to get all books that belong to a specified challengeid.
     */

    public function getBooksOfChallenge($challengeid){
        $books = DB::table('books')->where('challengeid', $challengeid)->get();
        return $books;
    }

    public function insertBookToChallenge(Request $request, $challengeid){
        $user = auth()->user();
        $data = $request->all();

        if($user && $user['id']){
            $insertbook = DB::table('books')->insert([
                'userid' => $user['id'], 'name' => $data['book'], 'author' => $data['author'], "challengeid" => $challengeid
            ]);

            if($insertbook == '1'){
                return json_encode("OK");
            }else{
                return json_encode("Error");
            }
        }
    }

    public function deleteBookFromChallenge($challengeid, $bookid){
        $user = auth()->user();

        if($user && $user['id']){
            $deletebook = DB::table('books')->where('id', $bookid)->where('challengeid', $challengeid)->delete();

            if($deletebook == '1'){
                return json_encode("OK");
            }else{
                return json_encode("Error");
            }
        }
    }
}
