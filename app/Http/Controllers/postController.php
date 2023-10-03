<?php

namespace App\Http\Controllers;
use App\Models\Student;

use App\Models\Post;
use Illuminate\Http\Request;

class postController extends Controller
{
    public function index()
    {    
        // $galer = Student::paginate(1);
        $galer = Student::limit(6)->orderByDesc('created_at')->get();
        return view('index', compact ('galer'));
       
    }
    public function all()
    {
        $galer = Student::orderByDesc('created_at')->paginate(6);
        
        return view('port', compact ('galer'));
    }
    public function allshow($id)
    {
        $student = Student::find($id);
        return view('port',compact('student'));
    }
    public function show($id)
    {
        $student = Student::find($id);
        return view('detail',compact('student'));
    }
    
}
