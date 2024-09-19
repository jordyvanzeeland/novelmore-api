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
     * Function to get all books that belong of a challenge.
     * Specified by a challengeid
     */

    public function getBooksOfChallenge($challengeid){
        $books = DB::table('books')->where('challengeid', $challengeid)->get();
        return $books;
    }

    /**
     * Function to Insert a book to a challenge
     * Specified by a challengeid
     */

    public function insertBookToChallenge(Request $request, $challengeid){
        $data = $request->all();
        $user = auth()->user();

        $insertbook = DB::table('books')->insert([
            'userid' => $user['id'], 'name' => $data['book'], 'author' => $data['author'], "challengeid" => $challengeid
        ]);
        return $insertbook;
    }

    /**
     * Function to delete a book from a challenge
     * Specified by a challengeid and a bookid
     */

    public function deleteBookFromChallenge($challengeid, $bookid){
        $deletebook = DB::table('books')->where('id', $bookid)->where('challengeid', $challengeid)->delete();
        return $deletebook;
    }

    /**
     * Function to update the readed status of a book from a challenge
     * Specified by a challengeid and a bookid
     */

    public function checkBookOfChallenge(Request $request, $challengeid, $bookid){
        $data = $request->all();
        $updateBook = DB::table('books')->where('id', $bookid)->where('challengeid', $challengeid)->update([
            'readed' => $data['readed']
        ]);
        return $updateBook;
    }
}
