@props(['messages'])

@if ($messages)
    <div class="border-2 border-red-600 bg-red-600 bg-opacity-30 rounded-md p-2">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

    </div>
@endif
