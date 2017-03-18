@extends('shopify::embedded')

@section('title', 'Dashboard')

@section('content')
    <div class="section">
        <div class="section-summary">
            <h1>Dashboard</h1>
            <p>Your app dashboard</p>
        </div>
        <div class="section-content">
            <div class="section-row">
                <div class="section-cell">
                    <h1>Welcome to {{ config('app.name') }}!</h1>
                    <p>Your current plan is <strong>{{ $user->getCurrentPlan() }}</strong></p>
                    <p><a href="{{ route('shopify.plans') }}" class="btn primary">View plans</a></p>

                </div>
            </div>
        </div>
    </div>
@endsection