<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    //show the form for creating a new resource
    public function index()
    {
        $user = auth()->user(); 
        //dd($user);
        //$data = Todo::all();
        $data = $user->todos;
        //dd($data);
        return Inertia::render('todos',['data' => $data]);
    }

    public function store(Request $request)
    {
        //dd($request);
        $data = Validator::make($request->all(),[
            'name' => ['required'],
        ])-> validate();

        $user = auth()->user();

        $user->todos()->create($data);

        //return redirect()->back()->with('message','Task created successfully.');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        Validator::make($request->all(),[
            'name' => ['required'],
        ])->validate();

        if ($request->has('id')){
            Todo::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message','Task updated successfully.');
        }
    }


    public function destroy(Request $request){
        if ($request->has('id')){
            Todo::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}