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
    public function create(Request $request)
    {
        //  Get request data
        $data = request()->json()->all();

        // validate
        $validator = Validator::make($data, Todo::rules());

        //  return errors if validation fails
        if($validator->fails()){
            return response()->json(array('errors' => $validator->errors()), 400);
        }

        // New todo
        $todo = new Todo();
        $created = $todo->create([
            'title' => $data['title'],
            'user_id' => $data['user'],
            'description' => isset($data['description']) ? $data['description'] : NULL,
            'group_id' => isset($data['group']) ? $data['group'] : NULL,
            'type' => isset($data['type']) ? $data['type'] : NULL
        ]);
        
        //  return 201 if created successfuly
        if($created){
            return response()->json($created, 201);
        }else{
            return response()->json(array('message' => 'There was an error creating todo'), 400);
        }
        return back();
        //
    }

    /**
     * Display a specific todo
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        if($todo){
            return response()->json($todo, 200);
        }

        return response()->json(array('message' => 'Not Found!'), 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Todo $todo)
    {
       
        // return $todo->title;
        // return request()->title;
        if($todo){
            // //  Get request data
            $data = request()->json()->all();

            //  validation rules
            $rules = array(
                'title' => isset($data['title']) ? 'required|max:255' : '',
                'description' => isset($data['description']) ? 'nullable' : '',
                'user' => isset($data['user']) ?  'required|exists:users,id' : '',
                'group' => isset($data['group']) ? 'nullable|exists:groups,id' : '',
                'type' => isset($data['type']) ? 'nullable|max:150' : ''
            );

            // // validate
            $validator = Validator::make($data, $rules);

            // //  return errors if validation fails
            if($validator->fails()){
                return response()->json(array('errors' => $validator->errors()), 400);
            }

            // Update Todo with updated data
            $todo->title = isset($data['title']) ? $data['title'] : $todo->title;
            $todo->description = isset($data['description']) ? $data['description'] : $todo->description;
            $todo->user_id = isset($data['user']) ? $data['user'] : $todo->user_id;
            $todo->group_id = isset($data['group']) ? $data['group'] : $todo->group_id;
            $todo->type = isset($data['type']) ? $data['type'] : $todo->type;
            $updated = $todo->save();

            if($updated){
                return response()->json($todo, 200);
            }else{
                return response()->json(array('message' => 'There was an error updating todo'), 400);
            }
        }

        return response()->json(array('message' => 'Not Found!'), 404);
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

        return response()->json(array('message' => 'Not Found!'), 404);
    }
}
