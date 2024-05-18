<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Submits Report</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center px-6">
            <img class="w-40" src="{{ asset('images/al-dawaa-logo-2.2.png') }}" alt="Al-Dawaa">
            <span class="text-gray-500/60 text-base"> Date:&nbsp; {{ today()->toFormattedDateString() }} </span>
        </div>

        <div class="mt-10 flex items-center justify-center">
            <h1 class="text-gray-800 text-2xl tracking-wider">Submits Report</h1>
        </div>

        <div class="mt-6 flex flex-grow-0">
            <a class="ml-4" href="{{ route('formSubmits.report.export') }}" title="Export Pdf" target="__blank">
                <img class="w-10 h-10" src="{{ asset('images/pdf.svg') }}" alt="Pdf">
            </a>
        </div>

        <table class="mt-4 min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="p-5 text-left text-base font-normal text-gray-500 tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="p-5 text-left text-base font-normal text-gray-500 tracking-wider">
                        Date of birth
                    </th>
                    <th scope="col" class="p-5 text-left text-base font-normal text-gray-500 tracking-wider">
                        Gender
                    </th>
                    <th scope="col-span-2" class="p-5 text-left text-base font-normal text-gray-500 tracking-wider">
                        Nationality
                    </th>
                    <th scope="col-span-2" class="p-5 text-left text-base font-normal text-gray-500 tracking-wider">
                        HR Coordinator Status
                    </th>
                    <th scope="col-span-2" class="p-5 text-left text-base font-normal text-gray-500 tracking-wider">
                        HR Manager Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($formSubmits as $submit)
                    <tr>
                        <td class="p-6 whitespace-nowrap">
                            <div class="text-base text-gray-700">
                                {{ ucwords($submit->name) }}
                            </div>
                        </td>
                        <td class="p-6 whitespace-nowrap">
                            <div class="text-base  text-gray-700">
                                <span>
                                    {{ \Illuminate\Support\Carbon::parse($submit->dob)->toFormattedDateString() }}
                                </span>
                            </div>
                        </td>
                        <td class="p-6 whitespace-nowrap">
                            <div class="text-base  text-gray-700">
                                <span>
                                    {{ ucwords($submit->gender) }}
                                </span>
                            </div>
                        </td>
                        <td class="p-6 whitespace-nowrap">
                            <div class="text-base  text-gray-700">
                                <span>
                                    {{ $submit->nationality }}
                                </span>
                            </div>
                        </td>
                        <td class="p-6 whitespace-nowrap">
                            <div class="text-base  text-gray-700">
                                @if ($status = $submit->hr_coordinator_status)
                                    @if ($status == \App\Enums\SubmitStatusType::Approved->value)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-500 h-5 w-5"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500 h-5 w-5"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                @else
                                    <span> - </span>
                                @endif
                            </div>
                        </td>
                        <td class="p-6 whitespace-nowrap">
                            <div class="text-base  text-gray-700">
                                @if ($status = $submit->hr_manager_status)
                                    @if ($status == \App\Enums\SubmitStatusType::Approved->value)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-500 h-5 w-5"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500 h-5 w-5"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                @else
                                    <span> - </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
