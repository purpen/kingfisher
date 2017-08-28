<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class SaasFeedbackController extends Controller
{
    // 反馈信息列表展示
    public function lists(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;

        $lists = Feedback::with('User')->orderBy('id', 'desc')->paginate($per_page);

        return view('home/saasFeedback.index', ['lists' => $lists, 'per_page' => $per_page]);
    }
}