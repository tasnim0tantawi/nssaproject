<?php

namespace App\Http\Controllers;

use App\Models\CollaborationRequest;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectOwnerController extends Controller
{
    //

    public function get_my_projects(Request $request){
        $user_id = auth()->user()->id;
        $projects = Project::where('owner_id', $user_id)->get();
        return response()->json($projects, 200);
    }

    
    public function get_all_projects_requests(){
        $user_id = auth()->user()->id;
        $projects = Project::where('owner_id', $user_id)->get();
        $project_requests = CollaborationRequest::whereIn('project_id', $projects->pluck('id'))->get();
        return response()->json($project_requests, 200);

    }

    public function get_project_requests(Project $project){
        $project_requests = CollaborationRequest::where('project_id', $project->id)->get();
        return response()->json($project_requests, 200);
    }

    public function accept_project_request(CollaborationRequest $project_request){
        $project_request->status = 'accepted';
        $project_request->save();
        return response()->json($project_request, 200);
    }

    public function reject_project_request(CollaborationRequest $project_request){
        $project_request->status = 'rejected';
        $project_request->save();
        return response()->json($project_request, 200);
    }

    public function delete_project_request(CollaborationRequest $project_request){
        $project_request->delete();
        return response()->json(null, 204);
    }

    public function get_project_collaborators(Project $project){
        $project_collaborators = CollaborationRequest::where('project_id', $project->id)->where('status', 'accepted')->get();
        return response()->json($project_collaborators, 200);
    }

    
}
