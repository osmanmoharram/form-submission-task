@extends('layouts.app')

@section('main')
    <div class="flex flex-col p-20 text-base">
        @role ('hr_coordinator')
            <div class="flex flex-grow-0">
                <a href="{{ route('formSubmits.report.show') }}"
                    class="text-center px-6 py-3 text-sm rounded-full font-medium bg-indigo-300 hover:bg-indigo-400 text-white cursor-pointer transition-all"
                    target="__blank"
                >
                    Show Report
                </a>
            </div>
        @endrole

        <div class="hidden lg:flex flex-col mt-4">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 sm:rounded">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-normal text-gray-500 tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-normal text-gray-500 tracking-wider">
                                        Date of birth
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-normal text-gray-500 tracking-wider">
                                        Gender
                                    </th>
                                    <th scope="col-span-2"
                                        class="px-6 py-3 text-left text-base font-normal text-gray-500 tracking-wider">
                                        Nationality
                                    </th>
                                    <th scope="col-span-2"
                                        class="px-6 py-3 text-left text-base font-normal text-gray-500 tracking-wider">
                                        HR Coordinator Status
                                    </th>
                                    <th scope="col-span-2"
                                        class="px-6 py-3 text-left text-base font-normal text-gray-500 tracking-wider">
                                        HR Manager Status
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
                                            <div class="text-base text-gray-700">
                                                {{ ucwords($submit->name) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-base  text-gray-700">
                                                <span>
                                                    {{ \Illuminate\Support\Carbon::parse($submit->dob)->toFormattedDateString() }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-base  text-gray-700">
                                                <span>
                                                    {{ ucwords($submit->gender) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-base  text-gray-700">
                                                <span>
                                                    {{ $submit->nationality }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-base  text-gray-700">
                                                @if ($status = $submit->hr_coordinator_status)
                                                    @if ($status == \App\Enums\SubmitStatusType::Approved->value)
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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-base  text-gray-700">
                                                @if ($status = $submit->hr_manager_status)
                                                    @if ($status == \App\Enums\SubmitStatusType::Approved->value)
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
                                                <a href="{{ route('formSubmits.cv', $submit) }}" target="__blank"
                                                    class="flex items-center justify-center py-2 px-3 text-xs rounded-full font-medium bg-amber-100 hover:bg-amber-200 text-amber-900 cursor-pointer transition-all">
                                                    Show CV
                                                </a>

                                                <form action="{{ route('formSubmits.update', $submit) }}" method="post">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="status" value="approved">

                                                    <button type="submit" href="{{ route('formSubmits.download', $submit) }}"
                                                        class="flex items-center justify-center py-2 px-3 text-xs rounded-full font-medium bg-green-100 hover:bg-green-200 text-green-900 cursor-pointer transition-all">
                                                        Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('formSubmits.update', $submit) }}" method="post">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="status" value="rejected">


                                                    <button type="submit" href="{{ route('formSubmits.download', $submit) }}"
                                                        class="flex items-center justify-center py-2 px-3 text-xs rounded-full font-medium bg-red-100 hover:bg-red-200 text-red-900 cursor-pointer transition-all">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 whitespace-nowrap">
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
@endsection
