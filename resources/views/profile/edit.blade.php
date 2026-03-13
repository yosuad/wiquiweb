@extends('layouts.admin')

@section('title', 'Profile')

@php $pageTitle = 'Profile'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">My profile</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; align-items: start;">

        <div class="form-container form-container--spaced">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="form-container form-container--spaced">
            @include('profile.partials.update-password-form')
        </div>

        <div class="form-container form-container--spaced">
            @include('profile.partials.delete-user-form')
        </div>

    </div>

@endsection