<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display the todos created
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get no items per page if set by the client
        $perPage = $request->query('perPage');

        if(!$perPage){
            $perPage = 10; // Default no of items per page
        }
        $todos = Todo::latest()->paginate($perPage);
        return response()->json($todos, 200);
    }

    /**
     * Create todo
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // validate
        // $validator = $this->validate($request, Todo::rules());
        $validator = Validator::make(request()->json()->all(), Todo::rules());

         
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $todo = new Todo();
        $created = $todo->create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user,
            'group_id' => $request->group,
            'type' => $request->type
        ]);
        

        if($created){
            return response()->json($created, 201);
        }else{
            return response()->json(array('message' => 'There was an error creating todo'), 400);
        }
        return back();
        //
    }

    /**
     * Display a todo
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        if($todo){
            return response()->json($todo, 200);
        }

        return response()->json(array('message' => 'Todo doesn\'t exist'), 400);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if($todo){
            $updated = $todo->update([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user,
                'group_id' => $request->group,
                'type' => $request->type
            ]);

            if($updated){
                return response()->json($updated, 201);
            }else{
                return response()->json(array('message' => 'There was an error updating todo'), 400);
            }
        }

        return response()->json(array('message' => 'Todo doesn\'t exist'), 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo){
            $todo->delete();
            return response()->json(array('message' => 'Todo was deleted successfully'), 204); 
        }

        return response()->json(array('message' => 'Todo doesn\'t exist'), 400);
    }
}
