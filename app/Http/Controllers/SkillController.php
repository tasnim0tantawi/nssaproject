<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        $skill = Skill::create(
            [
                'title' => $request->title,
                'description' => $request->description,
            ]
        );
            

        return response()->json($skill, 201);
    }

    public function delete(Skill $skill)
    {
        $skill->delete();

        return response()->json(null, 204);
    }

}
