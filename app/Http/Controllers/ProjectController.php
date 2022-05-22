<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Projects/Index', [
            'projects' => $request->user()->projects()->with('tasks')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'color' => ['max:255'],
        ]);

        Project::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'color' => $data['color'] ?? '#0000',
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Successfully created new Project.');

        return redirect()->back();
    }

    public function tasks(Project $project)
    {
        $tasks = $project->tasks()->get();
        session()->flash('message', 'Successfully retrieved Tasks.');

        return $tasks;
    }
}
