<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->with('tasks')->get();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'color' => ['string', 'max:255'],
        ]);

        Project::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'color' => $data['color'],
            'stage' => 0,
            'user_id' => auth()->id(),
        ]);

        // session()->flash('flash.banner', 'Project was added successfully!');
        // session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
    }

    public function tasks(Project $project)
    {
        $tasks = $project->tasks()->get();
        // $projects = auth()->user()->projects()->with('tasks')->get();

        return $tasks;
    }
}
