@props(['messages'])

@if ($messages)
    <div class="border-2 border-green-600 bg-green-600 bg-opacity-30 rounded-sm p-2">
        <ul {{ $attributes->merge(['class' => 'text-sm text-green-600 dark:text-green-400 space-y-1']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

    </div>
@endif
