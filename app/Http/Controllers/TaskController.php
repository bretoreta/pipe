<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'max:255'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $task = Task::create([
            'project_id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'stage' => 0,
            'started_at' => now(),
            'ended_at' => null,
        ]);

        session()->flash('message', 'Successfully created new Task.');

        return $task;
    }
    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        session()->flash('message', 'Successfully deteled Task.');

        return 'ok';
    }

    public function done(Request $request, Task $task)
    {
        $task->stage = 11;
        $task->ended_at = now();
        $task->save();

        session()->flash('message', 'Successfully marked Task as done.');

        return 'ok';
    }

    public function start(Request $request, Task $task)
    {
        $task->stage = 1;
        $task->save();

        session()->flash('message', 'Successfully started Task.');

        return 'ok';
    }
}
