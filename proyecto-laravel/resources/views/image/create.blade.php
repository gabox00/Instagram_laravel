@extends('layouts.app')

@section('header')
    <h2>Publicar Imagen</h2>
@stop

@section('slot')
<x-guest-layout>
    <x-auth-card>
        
        <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data">
            @csrf

            <!-- Image  -->
            <div class="mt-4">
                <x-label for="image_path" :value="__('Imagen')" />
                <x-input id="image_path" class="block mt-6 w-full" type="file" name="image_path" required/>
            </div>

            <!-- Description  -->
            <div class="mt-4">
                <x-label for="description" :value="__('Descripción')" />
                <textarea id="description" class="block mt-6 w-full" name="description" required></textarea>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Publicar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@stop