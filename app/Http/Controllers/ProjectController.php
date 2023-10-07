<?php

namespace App\Http\Controllers;

use App\Models\CollaborationRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTag;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $project = Project::create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'owner_id' => $user_id,
                'experience' => $request->experience,
                'scope' => $request->scope,
                'objectives' => $request->objectives,

            ]
        );

        $tags = ProjectTag::create(
            [
                'project_id' => $project->id,
                'tag_id' => $request->tag_id,
            ]
        );



        return response()->json($project, 201);
    }

    public function delete(Project $project)
    {
        $project->delete();

        return response()->json(null, 204);
    }

    public function index()
    {
        // paginate(10) means that we will get 10 projects per page
        $projects = Project::with('tags')->paginate(20);

        return response()->json($projects, 200);
    }

    public function show(Project $project)
    {
        return response()->json($project, 200);
    }

    public function request_to_collaborate(Project $project)
    {
        $user_id = auth()->user()->id;
        CollaborationRequest::create(
            [
                'user_id' => $user_id,
                'project_id' => $project->id,
            ]
        );

        return response()->json(null, 204);
    }

    public function get_my_collaboration_requests()
    {
        $user_id = auth()->user()->id;
        $collaboration_requests = CollaborationRequest::where('user_id', $user_id)->where('status', 'pending')->get();

        return response()->json($collaboration_requests, 200);
    }


}
