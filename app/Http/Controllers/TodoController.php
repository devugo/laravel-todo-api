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
            return response()->json(array('errors' => $validator->errors(), 'success' => false), 400);
        }

        // New todo
        $todo = new Todo();
        $created = $todo->create([
            'title' => $data['title'],
            'description' => isset($data['description']) ? $data['description'] : NULL,
            'group_id' => isset($data['group']) ? $data['group'] : NULL,
            'type' => isset($data['type']) ? $data['type'] : NULL
        ]);
        
        //  return 201 if created successfuly
        if($created){
            return response()->json($created, 201);
        }

        return response()->json(array('message' => 'There was an error creating todo', 'success' => false), 400);
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

        return response()->json(array('message' => 'Not Found!', 'success' => false), 404);
    }


    /**
     * Update a specific todo
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Todo $todo)
    {
        // Check if todo exists
        if($todo){
            // //  Get request data
            $data = request()->json()->all();

            //  validation rules
            $rules = array(
                'title' => isset($data['title']) ? 'required|max:255' : '',
                'description' => isset($data['description']) ? 'nullable' : '',
                'group' => isset($data['group']) ? 'nullable|exists:groups,id' : '',
                'type' => isset($data['type']) ? 'nullable|max:150' : ''
            );

            // // validate
            $validator = Validator::make($data, $rules);

            // //  return errors if validation fails
            if($validator->fails()){
                return response()->json(array('errors' => $validator->errors(), 'success' => false), 400);
            }

            // Update Todo with updated data
            $todo->title = isset($data['title']) ? $data['title'] : $todo->title;
            $todo->description = isset($data['description']) ? $data['description'] : $todo->description;
            $todo->group_id = isset($data['group']) ? $data['group'] : $todo->group_id;
            $todo->type = isset($data['type']) ? $data['type'] : $todo->type;
            $updated = $todo->save();

            // If successfully updated
            if($updated){
                return response()->json($todo, 200);
            }else{
                return response()->json(array('message' => 'There was an error updating todo', 'success' => false), 400);
            }
        }

        return response()->json(array('message' => 'Not Found!', 'success' => false), 404);
    }

    /**
     * Delete a specific todo
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo){
            $todo->delete();
            return response()->json(array('message' => 'Todo was deleted successfully', 'success' => true), 204); 
        }

        return response()->json(array('message' => 'Not Found!', 'success' => false), 404);
    }
}
