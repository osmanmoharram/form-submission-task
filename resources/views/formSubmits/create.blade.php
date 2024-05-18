@extends('layouts.master')

<div class="w-full h-full bg-no-repeat object-cover"
    style="background-image: url({{ asset('images/children-laying-on-the-ground.jpg') }})">
    <div class="w-screen h-screen bg-white/80 flex items-center justify-center">
        <div class="w-96 flex flex-col items-center justify-center space-y-10">
            <x-flash />
            
            <form class="w-full" action="{{ route('formSubmits.store') }}" method="post" enctype="multipart/form-data">
                @csrf
    
                <div class="flex flex-col justify-center items-center space-y-8">
                    <img class="h-56" src="{{ asset('images/al-dawaa-logo-removebg-preview.png')}}" alt="Al-dawaa">
    
                    <div class="w-full relative">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="pl-0 w-full peer text-[#162753] bg-transparent placeholder-transparent border-transparent border-b-2 border-b-gray-400/60 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-2 focus:border-b-[#162753]"
                            placeholder="Name"
                            required
                        />
    
                        <label for="name"
                            class="absolute text-[#162753] left-0 -top-3.5 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#162753] transition-all">Name</label>
                    </div>
    
    
                    <div class="w-full relative">
                        <input
                            type="date"
                            id="dob"
                            name="dob"
                            value="{{ old('dob') }}"
                            class="pl-0 peer w-full text-[#162753] bg-transparent placeholder-transparent border-transparent border-b-2 border-b-gray-400/60 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-2 focus:border-b-[#162753]"
                            placeholder="Date of birth"
                            required
                        />
    
                        <label for="dob"
                            class="absolute text-[#162753] left-0 -top-3.5 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#162753] transition-all">
                            Date of birth
                        </label>
                    </div>

                    <div class="w-full relative">
                        <select id="nationality" name="nationality"
                            class="pl-0 peer w-full text-[#162753] bg-transparent placeholder-transparent border-transparent border-b-2 border-b-gray-400/60 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-2 focus:border-b-[#162753]" required>
                            <option value="" @selected(old('nationality') == null) disabled>Please select your nationality</option>
                            @foreach ($nationalities as $nationality)
                                <option value="{{ $nationality->name }}" @selected(old('nationality') == $nationality->name)>
                                    <img src="{{ asset('images/flags/png/' . strtolower($nationality->code) . '.png') }}" alt="{{ $nationality->name }}">
                                    <span>{{ $nationality->name }}</span>
                                </option>
                            @endforeach
                        </select>
    
                        <label for="nationality"
                            class="absolute text-[#162753] left-0 -top-3.5 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#162753] transition-all">
                            Nationality
                        </label>
                    </div>

                    <div class="w-full relative">
                        <select id="gender" name="gender"
                            class="pl-0 peer w-full text-[#162753] bg-transparent placeholder-transparent border-transparent border-b-2 border-b-gray-400/60 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-2 focus:border-b-[#162753]" required>
                            <option value="" @selected(old('gender') == null) disabled>Please select your gender</option>
                            <option value="male" @selected(old('gender') == 'male')>Male</option>
                            <option value="female"  @selected(old('gender') == 'female')>Female</option>
                        </select>
    
                        <label for="gender"
                            class="absolute text-[#162753] left-0 -top-3.5 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#162753] transition-all">
                            Gender
                        </label>
                    </div>
    
                    <div class="w-full text-left">
                        <label for="cv"
                            class="relative w-full cursor-pointer text-[#162753] focus-within:outline-none focus-within:ring-0 hover:underline">
                            <span>Upload your cv file</span>
                            <input id="cv" name="cv" type="file" class="sr-only" accept=".pdf" required>
                        </label>
                    </div>
    
                    <div class="flex flex-col justify-center items-center space-y-5">
                        <button type="submit" class="px-8 py-2 text-lg rounded-sm text-white cursor-pointer bg-[#162753]">
                            Submit
                        </button>
    
                        <span class="text-base"> Or </span>
    
                        <a href="{{ route('login') }}" class="text-base text-[#162753] hover:underline">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>