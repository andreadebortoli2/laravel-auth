<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.projects.index', ['projects' => Project::orderByDesc('id')->paginate(8)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // validate data
        $validated = $request->validated();

        // add image to storage
        if ($request->has('image'))
            $image = Storage::put('project-images', $request['image']);
        $validated['image'] = $image;

        // create and add slug
        $slug = Str::slug($request->title, '-');
        $validated['slug'] = $slug;

        Project::create($validated);

        return to_route('admin.projects.index')->with('status', "$request->title - Project created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->all();
        $slug = Str::slug($request->title, '-');
        $validated['slug'] = $slug;

        $project->update($validated);

        return to_route('admin.projects.show', $project)->with('status', 'Project correctly edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('status', "$project->title - Project deleted");
    }
}
