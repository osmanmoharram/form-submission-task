@extends('layouts.app')

<div class="w-full h-full bg-no-repeat object-cover"
    style="background-image: url({{ asset('images/children-laying-on-the-ground.jpg') }})">
    <div class="w-screen h-screen bg-white/80 flex items-center justify-center">
        <form action="{{ route('login') }}" method="post" enctype="application/x-www-form-urlencoded">
            @csrf

            <div class="flex flex-col justify-center items-center space-y-8">
                <img class="h-56" src="{{ asset('images/al-dawaa-logo-removebg-preview.png')}}" alt="Al-dawaa">

                <div class="relative">
                    <input type="text" id="email" name="email"
                        class="pl-0 peer w-96 text-[#162753] bg-transparent placeholder-transparent border-transparent border-b-2 border-b-gray-400/60 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-2 focus:border-b-[#162753]"
                        placeholder="Email" />

                    <label for="email"
                        class="absolute text-[#162753] left-0 -top-3.5 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#162753] transition-all">Email</label>
                </div>

                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="pl-0 peer w-96 text-[#162753] bg-transparent placeholder-transparent border-transparent border-b-2 border-b-gray-400/60 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-2 focus:border-b-[#162753]"
                        placeholder="Password" />

                    <label for="password"
                        class="absolute text-[#162753] left-0 -top-3.5 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#162753] transition-all">Password</label>
                </div>

                <div class="flex flex-col justify-center items-center space-y-5">
                    <button type="submit" class="px-8 py-2 text-lg rounded-sm text-white cursor-pointer bg-[#162753]">
                        Login
                    </button>

                    <span class="text-base"> Or </span>

                    <a href="{{ route('home') }}" class="text-base text-[#162753] hover:underline">Submit your form</a>
                </div>
            </div>
        </form>
    </div>
</div>