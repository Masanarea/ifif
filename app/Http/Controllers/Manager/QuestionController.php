<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserQuizState;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $managerId = Auth::guard("manager")->user()->id;

        $questions = Question::where("manager_id", $managerId)
            ->with("options")
            ->get();

        return view("manager.question_list", compact("questions"));
    }
}
