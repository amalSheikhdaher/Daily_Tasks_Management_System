@extends('tasks.layouts')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Task List</div>
                <div class="card-body">

                    @can('admin-actions')
                        <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm my-2">
                            <i class="bi bi-plus-circle"></i> Add New Task
                        </a>
                    @endcan

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->due_date }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-eye"></i> Show
                                            </a>

                                            @can('admin-actions')
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>

                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Do you want to delete this task?');">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            @endcan

                                            @can('user-actions')
                                                <a href="{{ route('tasks.editStatus', $task->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-toggle-on"></i> Update Status
                                                </a>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="6">
                                    <span class="text-danger">
                                        <strong>No Task Found!</strong>
                                    </span>
                                </td>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $tasks->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
