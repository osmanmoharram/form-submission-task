@extends('layouts.master')

@section('content')
    <div class="min-h-screen overflow-y-auto grid grid-cols-12">
        <aside class="col-span-2 bg-[#162753]">
            <div class="mt-8 flex items-center justify-center">
                <img class="w-48" src="{{ asset('images/al-dawaa-logo-3.png') }}" alt="Al-dawaa">
            </div>

            <ul class="text-lg font-medium px-6 mt-16 space-y-3 tracking-wide">
                <li class="w-full">
                    <a class="w-full flex items-center space-x-3 px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-white/10 rounded-sm text-white' : 'hover:text-white' }} text-gray-300 transition-all"
                        href="{{ route('dashboard') }}">
                        <span class="block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                        </span>
                        <span class="block">Dashboard</span>
                    </a>
                </li>

                <li class="w-full">
                    <a class="w-full flex items-center space-x-3 px-4 py-2 {{ request()->routeIs('formSubmits.index') ? 'bg-white/10 rounded-sm text-white' : 'hover:text-white' }} text-gray-300  transition-all"
                        href="{{ route('formSubmits.index') }}">
                        <span class="block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </span>
                        <span class="block"> Form submits </span>
                    </a>
                </li>
            </ul>
        </aside>

        <main class="col-span-10 bg-gray-50">
            <nav class="bg-white h-24 shadow-md flex justify-end items-center px-8">
                <div x-data="{ isOpen: false }" class="relative">
                    <button @click="isOpen = ! isOpen"
                        class="w-12 h-12 rounded-full bg-sky-200 font-semibold text-white text-lg">
                        {{ auth()->user()->initials }}
                    </button>

                    <div x-show="isOpen" @click.away="isOpen = false"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="origin-top-right absolute right-0 mt-2 w-48 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 rounded"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                        <ul class="text-gray-400">
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex rounded items-center space-x-2 font-medium text-left py-3 px-4 hover:bg-[#162753] hover:text-gray-300">
                                        <span class="block">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                            </svg>
                                        </span>
                                        <span class="block">Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('main')
        </main>
    </div>
@endsection
