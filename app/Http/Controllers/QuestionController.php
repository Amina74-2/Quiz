<?php

namespace App\Http\Controllers;
use App\Models\Reponse;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $questions=Question::with('Reponses')->get();
       return Inertia::render('Questions',[
        'questions'=>$questions
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $question = $requestData['question'];
    
        // Save question 
        $newQuestion = new Question;
        $newQuestion->question = $question;
        $newQuestion->save();


        $answers=$requestData['answer'];
        foreach($answers as $answer){
            $newAnswer=new Reponse ;
            $newAnswer->reponse=$answer['answer'];
            $newAnswer->question_id=$newQuestion->id;
            $newAnswer->save();
        }
        return redirect('/questions')->with('success','Question and answers created successfuly');
        
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
      $id=$request['id'];
      $editquestion=Question::findorfail($id);
      $editquestion->question=$request['question'];
        $editquestion->save();

        return redirect('/questions')->with('success','Question edited successffuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
       
        $question->Reponses()->delete();
    
        
        $question->delete();
    
        return redirect('/questions')->with('success', 'Question and related responses deleted successfully');
    }
}