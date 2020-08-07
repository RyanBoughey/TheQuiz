<?php

namespace App\Http\Controllers;

use App\Responce;
use Illuminate\Http\Request;

class ResponceController extends Controller
{

    private $quiz;

    public function __construct()
    {
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
        // grab the json and show the view for the form
        $ordered_questions = array();
        foreach ($this->quiz->questions as $key => $question) {
            $ordered_questions[$question->sequence] = $question;
            $ordered_questions[$question->sequence]->key = $key;
            if (count($question->scores) > 1) {
                $ordered_questions[$question->sequence]->type = 'radio';
            } else {
                $ordered_questions[$question->sequence]->type = 'text';
            }
        }
        ksort($ordered_questions);
        return view('quiz', ['ordered_questions' => $ordered_questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        $responce = Responce::create($request->all());
        return redirect()->route('show_responce', ['responce' => $responce->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Responce  $responce
     * @return \Illuminate\Http\Response
     */
    public function show(Responce $responce)
    {
        $leaderboard = Responce::orderBy('score', 'DESC')->get();
        $rank = 1;
        foreach ($leaderboard as $key => $item) {
            if ($item->id == $responce->id) {
                $responce->rank = $rank;
            }
            if ($rank < 31) {
                $item->rank = $rank;
            } else {
                unset($leaderboard[$key]);
            }
        }
        return view('leaderboard', ['leaderboard' => $leaderboard, 'my_result' => $responce]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Responce  $responce
     * @return \Illuminate\Http\Response
     */
    public function edit(Responce $responce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Responce  $responce
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responce $responce)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Responce  $responce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responce $responce)
    {
        //
    }
}
