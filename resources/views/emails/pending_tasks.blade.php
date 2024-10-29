<div style="font-family: Arial, sans-serif; color: #333;">
    <h1>Your Pending Tasks for Today</h1>
    <p>Hello {{ $user->name }},</p>

    @if ($tasks->isEmpty())
        <p>You have no pending tasks for today. Enjoy your day!</p>
    @else
        <p>Here is the list of your pending tasks:</p>
        <ul>
            @foreach ($tasks as $task)
                <li><strong>{{ $task->title }}</strong>: {{ $task->description }} (Due Date: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }})</li>
            @endforeach
        </ul>
        <p>Please ensure to complete them as soon as possible.</p>
    @endif

    <p>Thanks,<br>{{ config('app.name') }}</p>
</div>
