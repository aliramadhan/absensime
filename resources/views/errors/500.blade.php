@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
<a href="https://attendance.pahlawandesignstudio.com/" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none ">Back to App</a>
@section('message', __('Server Error'))
