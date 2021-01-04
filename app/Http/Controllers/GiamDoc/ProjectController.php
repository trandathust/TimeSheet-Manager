<?php

namespace App\Http\Controllers\GiamDoc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GiamDoc\ProjectRequest;
use App\Models\Project;
use Carbon\Carbon;

class ProjectController extends Controller
{
    private $project;
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
    public function getViewProject()
    {
        $listProject = $this->project->all();
        return view('giamdoc.project.view', compact('listProject'));
    }
    public function getAddProject()
    {
        return view('giamdoc.project.add');
    }
    public function postAddProject(ProjectRequest $request)
    {
        $this->project->create([
            'name' => $request->name,
            'description' => $request->description,
            'end_time' => $request->end_time,
            'start_time' => $request->start_time,
            'status' => $request->status,
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }

    public function getEditProject($id)
    {
        $project = $this->project->findOrFail($id);
        return view('giamdoc.project.edit', compact('project'));
    }
    public function postEditProject(ProjectRequest $request, $id)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        if ($request->end_time < $now && $request->end_time != null) {
            return response()->json([
                'code' => 700,
                'message' => 'success'
            ], 200);
        }
        $this->project->findOrFail($id)->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => $request->status,
            ]
        );
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
    public function deleteProject($id)
    {
        $this->project->findOrFail($id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
}
