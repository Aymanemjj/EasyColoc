<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if (auth()->user()->reputation >= 0)
                <div class="font-semibold text-lg text-gray-800 dark:text-green-600 leading-tight">
                    <h2>Your reputation: {{ auth()->user()->reputation }}</h2>
                </div>
            @else
                <div class="font-semibold text-lg text-gray-800 dark:text-red-600 leading-tight">
                    <h2>Your reputation: {{ auth()->user()->reputation }}</h2>
                </div>
            @endif
        </div>
    </x-slot>

    @if (array_first($errors->get('type')))
        <x-message-success :messages="$errors->get('general')" class="mt-2" />
    @else
        <x-message-error :messages="$errors->get('general')" class="mt-2" />
    @endif

    <div class="py-12">

        {{-- Houses --}}
        @if (auth()->user()->notReserved())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('You have no house') }}
                    </div>
                </div>
            </div>
        @else
            @foreach (auth()->user()->house as $house)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            @if ($house->authIsOwner())
                                <small class="bg-yellow-500 text-black p-2 rounded-md">Owner</small>
                            @endif
                            <a href="house/{{ $house->id }}/details">{{ $house->title }}</a>
                            <small
                                class="bg-gray-500 dark:bg-slate-700 rounded-md p-2">{{ $house->description }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Balance</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Paid</span>
                            <span
                                class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalPaid, 2) }}
                                $</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Payment History</h3>
                        {{-- Month Filter --}}
                        <form method="GET" action="{{ route('dashboard') }}">
                            <select name="month" onchange="this.form.submit()"
                                class="text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">All months</option>
                                @foreach ($availableMonths as $month)
                                    <option value="{{ $month }}"
                                        {{ request('month') == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <table class="w-full text-center text-white">
                        <tr class="border-b">
                            <th class="border-x px-2 py-2">Expense</th>
                            <th class="border-x px-2 py-2">Category</th>
                            <th class="border-x px-2 py-2">House</th>
                            <th class="border-x px-2 py-2">Amount</th>
                            <th class="border-x px-2 py-2">Date</th>
                            <th class="border-x px-2 py-2">Status</th>
                        </tr>
                        <thead></thead>
                        <tbody>
                            @forelse ($paymentHistory as $payment)
                                <tr class="border-b border-gray-700">
                                    <td class="border-r px-2 py-2">{{ $payment->expence->title }}</td>
                                    <td class="border-r px-2 py-2">
                                        <div
                                            class="bg-white bg-opacity-30 text-white border-2 border-white rounded-md px-1 size-fit mx-auto">
                                            <small>{{ $payment->expence->category->name }}</small>
                                        </div>
                                    </td>
                                    <td class="border-r px-2 py-2">{{ $payment->expence->house->title }}</td>
                                    <td class="border-r px-2 py-2">{{ $payment->amount }} $</td>
                                    <td class="border-r px-2 py-2">{{ $payment->expence->date }}</td>
                                    <td class="border-r px-2 py-2">
                                        @if ($payment->status)
                                            <span class="text-green-400 font-semibold">Paid</span>
                                        @else
                                            <span class="text-red-400 font-semibold">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-gray-400">No payment history found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $paymentHistory->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
