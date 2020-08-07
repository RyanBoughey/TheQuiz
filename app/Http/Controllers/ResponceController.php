<?php

namespace App\Http\Controllers;

use App\Responce;
use Illuminate\Http\Request;

class ResponceController extends Controller
{

    private $quiz;

    public function __construct()
    {
        // get the quiz in the constructor so that it can be used in multiple functions
        $json = file_get_contents("../storage/app/public/quiz.json");
        $this->quiz = json_decode($json);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // first, order the questions by the "sequence"
        $ordered_questions = array();
        foreach ($this->quiz->questions as $key => $question) {
            $ordered_questions[$question->sequence] = $question;
            $ordered_questions[$question->sequence]->key = $key;
            // add in some extra information about the type of input we'll need
            if (count($question->scores) > 1) {
                $ordered_questions[$question->sequence]->type = 'radio';
            } else {
                $ordered_questions[$question->sequence]->type = 'text';
            }
        }
        // now we actually do the sort, based on the re-keyed array
        ksort($ordered_questions);
        // return the view with the sorted questions
        return view('quiz', ['ordered_questions' => $ordered_questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
        // validate the responce from the quiz, all questions are required
        $validation_array = array();
        foreach ($this->quiz->questions as $key => $question) {
            $validation_array[$key] = 'required';
        }
        $validatedData = $request->validate($validation_array);
        // check the answers given against the json and score accordingly
        $score = 0;
        foreach ($this->quiz->questions as $key => $question) {
            foreach ($question->scores as $answer) {
                if (strtolower($request->input($key)) == strtolower($answer[0])) {
                    $score += $answer[1];
                }
            }
        }
        // now we go to the confirmation page, where the user inputs their name and email address
        return view('confirm', ['score' => $score]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the score, name and email address
        $validatedData = $request->validate([
            'score' => 'required|integer',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255'
        ]);
        // now we've passed the validation, we can put those straigt into a new Responce.
        $responce = Responce::create($request->all());
        // all saved, lets go to the leaderboard
        return redirect()->route('leaderboard', ['responce' => $responce->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Responce  $responce
     * @return \Illuminate\Http\Response
     */
    public function leaderboard(Responce $responce = null)
    {
        // we let $responce be optional so people can check the leaderboard whenever
        if (isset($responce) && $responce !== null) {
            // if we have a $responce, we'll want to work out that rank too.
            // while i believe there should be a more efficient way of doing this,
            // the current method to work out the rank of any given record
            // is to get all the records and itterate through them untill we reach
            // the required record.
            $leaderboard = Responce::orderBy('score', 'DESC')->get();
            $rank = 1;
            foreach ($leaderboard as $key => $item) {
                // once we find the right record, we assign it's rank
                if ($item->id == $responce->id) {
                    $responce->rank = $rank;
                }
                if ($rank < 31) {
                    $item->rank = $rank;
                } else {
                    // if we've gone over 30 records we remove the excess records from the result
                    unset($leaderboard[$key]);
                }
                $rank++;
            }
            // we then return the top 30 results along with the desired result
            return view('leaderboard', ['leaderboard' => $leaderboard, 'my_result' => $responce]);
        } else {
            // if we're not given a $responce it's much easier, just grab the top 30 results
            $leaderboard = Responce::orderBy('score', 'DESC')->limit(30)->get();
            $rank = 1;
            // itterate through those 30 and give them their rank
            foreach ($leaderboard as $key => $item) {
                $item->rank = $rank;
                $rank++;
            }
            // then return those ranked results
            return view('leaderboard', ['leaderboard' => $leaderboard, 'my_result' => null]);
        }
    }
}
