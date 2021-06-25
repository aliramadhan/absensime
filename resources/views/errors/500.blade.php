@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')

@section('message', __('Location Server Error : Please Check your Location Permission on browser and device'))
