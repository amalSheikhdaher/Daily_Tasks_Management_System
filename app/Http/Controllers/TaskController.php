<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * Retrieves tasks from the cache if available, otherwise fetches 
     * and caches the latest tasks for 5 minutes.
     *
     * @return View
     */
    public function index(): View
    {
        $tasks = Cache::remember('tasks', 60 * 5, function () {
            return Task::latest()->paginate(3);
        });

        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     *
     * After storing the task, the 'tasks' cache is cleared to ensure
     * the latest task is visible when fetching from cache.
     *
     * @param  StoreTaskRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create($request->all());
        Cache::forget('tasks');

        return redirect()->route('tasks.index')
            ->withSuccess('New task is added successfully.');
    }
    /**
     * Display the specified task.
     *
     * Caches the task for 5 minutes, or retrieves it from cache if available.
     *
     * @param  Task  $task
     * @return View
     */
    public function show(Task $task): View
    {
        $task = Cache::remember("task_.id", 60 * 5, function () use ($task) {
            return $task;
        });

        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  Task  $task
     * @return View
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task' => $task
        ]);
    }
    /**
     * Update the specified task in storage.
     *
     * Updates the task details and redirects to the task index page
     * with a success message.
     *
     * @param  UpdateTaskRequest  $request
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->all());
        Cache::forget('tasks');
        return redirect()->route('tasks.index')
            ->withSuccess('Task is updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * Deletes the task, clears the 'tasks' cache, and redirects to
     * the task index page with a success message.
     *
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        Cache::forget('tasks');

        return redirect()->route('tasks.index')
            ->withSuccess('Task is deleted successfully.');
    }

    /**
     * Show the form for editing the status of the specified task.
     *
     * @param  Task  $task
     * @return View
     */
    public function editStatus(Task $task): View
    {
        return view('tasks.edit-status', compact('task'));
    }

    /**
     * Update the status of the specified task.
     *
     * Updates the task's status and redirects to the task index page
     * with a success message.
     *
     * @param  UpdateStatusRequest  $request
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function updateStatus(UpdateStatusRequest $request, Task $task): RedirectResponse
    {
        $task->status = $request->status;
        $task->save();
        Cache::forget('tasks');
        return redirect()->route('tasks.index')
            ->with('success', 'Task status updated successfully!');
    }
}
