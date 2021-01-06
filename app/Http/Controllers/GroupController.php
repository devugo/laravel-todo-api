<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display the groups created
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //  Get all groups from the latest
        $groups = Group::latest()->get();
        return response()->json($groups, 200);
    }

    /**
     * Create a Group
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  Get request data
        $data = request()->json()->all();

        // validate
        $validator = Validator::make($data, Group::rules());

        //  return errors if validation fails
        if($validator->fails()){
            return response()->json(array('errors' => $validator->errors(), 'success' => false), 400);
        }

        // New Group
        $group = new Group();
        $created = $group->create([
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : NULL,
        ]);
        
        //  return 201 if created successfuly
        if($created){
            return response()->json($created, 201);
        }

        return response()->json(array('message' => 'There was an error creating group', 'success' => false), 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        if($group){
            return response()->json($group, 200);
        }

        return response()->json(array('message' => 'Not Found!', 'success' => false), 404);
    }

    /**
     * Update a specific todo
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Group $group)
    {
        // Check if group exists
        if($group){
            // //  Get request data
            $data = request()->json()->all();

            //  validation rules
            $rules = array(
                'name' => isset($data['name']) ? 'required|max:100' : '',
                'description' => isset($data['description']) ? 'nullable' : '',
            );

            // // validate
            $validator = Validator::make($data, $rules);

            // //  return errors if validation fails
            if($validator->fails()){
                return response()->json(array('errors' => $validator->errors(), 'success' => false), 400);
            }

            // Update group with updated data
            $group->name = isset($data['name']) ? $data['name'] : $group->name;
            $group->description = isset($data['description']) ? $data['description'] : $group->description;
            $updated = $group->save();

            // If successfully updated
            if($updated){
                return response()->json($group, 200);
            }else{
                return response()->json(array('message' => 'There was an error updating group', 'success' => false), 400);
            }
        }

        return response()->json(array('message' => 'Not Found!', 'success' => false), 404);
    }

    /**
     * Delete a specific group
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if($group){
            $group->delete();
            return response()->json(array('message' => 'Group was deleted successfully', 'success' => true), 204); 
        }

        return response()->json(array('message' => 'Not Found!', 'success' => false), 404);
    }
}
