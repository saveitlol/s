<?php
  
namespace App\Http\Controllers;
  
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::latest()->paginate(5);
      
        return view('students.index',compact('students'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        // $students = Student::all();
        // return stddetail
    }
    public function post()
    {
        $students = Student::all();
        return response()->json($students);
    }
    
    public function postById($id)
    {
        $students = Student::find($id);
        return response()->json($students);
    }
  
    public function create()
    {
        return view('students.create');
    }
  
    public function store(Request $request)
    {
        

        if ($request->image){
            $fileName = $this->generateRandomString();
            $extension = $request->image->extension();
            

            $a=Storage::disk('public')->putFileAs('image', $request->image, $fileName.'.'.$extension);
            // dd($a);
        }
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        // $request->image = $fileName.'.'.$extension;
        $request['image'] = $fileName.'.'.$extension;
        // dd($request->all());

        $student = new Student;
        $student->name = $request->name;
        $student->detail = $request->detail;
        $student->image = $fileName.'.'.$extension;
        $student->save();
        // Student::create($request->all());
       
        return redirect()->route('students.index')
                        ->with('success','Student created successfully.');
    }
  
    public function show(Student $student)
    {
        return view('students.show',compact('student'));
    }
  
    public function edit(Student $student)
    {
        return view('students.edit',compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
      
        $student->update($request->all());
      
        return redirect()->route('students.index')
                        ->with('success','Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $student->delete();
       
        return redirect()->route('students.index')
                        ->with('success','Student deleted successfully');
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}