@extends('layouts.app')

@section('header')
    <h2>Configuración</h2>
@stop

@section('slot')
<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ Auth::user()->name }}" required autofocus />
            </div>
        
            <!-- Surname -->
            <div class="mt-4">
                <x-label for="surname" :value="__('Surname')" />

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname"  value="{{ Auth::user()->surname }}" required autofocus />
            </div>

            <!-- Nick -->
            <div class="mt-4">
                <x-label for="nick" :value="__('Nick')" />

                <x-input id="nick" class="block mt-1 w-full" type="text" name="nick"  value="{{ Auth::user()->nick }}" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ Auth::user()->email }}" required />
            </div>

            <!-- Image  -->
            <div class="mt-4">

                <x-label for="image_path" :value="__('Avatar')" />

                @include('includes.avatar')

                <x-input id="image_path" class="block mt-6 w-full" type="file" name="image_path" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Guardar cambios') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@stop