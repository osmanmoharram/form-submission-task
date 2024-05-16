@extends('layouts.app')

@section('main')
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col py-12 text-base space-y-5">
            @if (session()->has('success'))
                <p class="py-3 px-4 text-base rounded bg-green-100 text-green-900">
                    {{ session()->has('success') }}
                </p>
            @endif

            @if (session()->has('error'))
                <p class="py-3 px-4 text-base rounded bg-red-100 text-red-900">
                    {{ session()->has('error') }}
                </p>
            @endif
            <div class="hidden lg:flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden border border-gray-200 sm:rounded">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-base font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-base font-medium text-gray-500 uppercase tracking-wider">
                                            Date of birth
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-base font-medium text-gray-500 uppercase tracking-wider">
                                            Gender
                                        </th>
                                        <th scope="col-span-2"
                                            class="px-6 py-3 text-left text-base font-medium text-gray-500 uppercase tracking-wider">
                                            Nationality
                                        </th>
                                        <th scope="col-span-2"
                                            class="px-6 py-3 text-left text-base font-medium text-gray-500 uppercase tracking-wider">
                                            Approval
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($formSubmits as $submit)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-base font-medium text-gray-900">
                                                    {{ ucwords($submit->name) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-base  text-gray-900">
                                                    <span>
                                                        {{ \Illuminate\Support\Carbon::parse($submit->dob)->toFormattedDateString() }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-base  text-gray-900">
                                                    <span>
                                                        {{ ucwords($submit->gender) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-base  text-gray-900">
                                                    <span>
                                                        {{ $submit->nationality }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-base  text-gray-900">
                                                    @php
                                                        $user = auth()->user();
                                                        $approval = $user->hasRole('hr_coordinator')
                                                            ? $submit->hr_coordinator_approval
                                                            : ($user->hasRole('hr_manager') ? $submit->hr_manager_approval : null);
                                                    @endphp

                                                    @if ($approval)
                                                        @if ($approval == 'approved')
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-green-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                    @else
                                                        <span> - </span>
                                                    @endif

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base ">
                                                <div class="flex flex-wrap items-center justify-left space-x-1">
                                                    <a href="{{ route('formSubmits.download', $submit) }}"
                                                        class="flex items-center justify-center px-4 py-2 text-sm rounded-full tracking-wide font-semibold bg-amber-100 hover:bg-amber-200 text-amber-900 cursor-pointer transition-all">
                                                        Download CV
                                                    </a>

                                                    <form action="{{ route('formSubmits.update', $submit) }}" method="post">
                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="approval" value="approved">

                                                        <button type="submit" href="{{ route('formSubmits.download', $submit) }}"
                                                            class="flex items-center justify-center px-4 py-2 text-sm rounded-full tracking-wide font-semibold bg-green-100 hover:bg-green-200 text-green-900 cursor-pointer transition-all">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('formSubmits.update', $submit) }}" method="post">
                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="approval" value="rejected">


                                                        <button type="submit" href="{{ route('formSubmits.download', $submit) }}"
                                                            class="flex items-center justify-center px-4 py-2 text-sm rounded-full tracking-wide font-semibold bg-red-100 hover:bg-red-200 text-red-900 cursor-pointer transition-all">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-10 whitespace-nowrap">
                                                <div class="space-y-3 text-base font-medium text-gray-900 flex flex-col items-center justify-center">
                                                    <img class="w-40" src="{{ asset('images/no-submits.svg') }}" alt="No Submits">

                                                    <p class="ml-5 text-lg text-gray-400/70">No form submits</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2"> {{ $formSubmits->links() }} </div>
        </div>
    </div>
@endsection
