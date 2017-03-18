@extends('shopify::stand_alone')

@section('title', 'Sign Up')

@section('content')
    <div class="section signup-form">
        <div class="section-content">
            <div class="section-row">
                <div class="section-cell">

                    <h1>{{ config('app.name') }}</h1>
                    <p>Please fill-in the form below to signup</p>

                    <form action="{{ route('shopify.install') }}" method="post">

                        {{ csrf_field() }}

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="box warning"><i class="ico-warning"></i>Oops! {{ $error }}</div>
                            @endforeach
                        @endif

                        @if ($plans)
                            <div class="input-wrapper">
                                <label>Choose your plan:</label>
                                <select name="plan">
                                    @foreach ($plans as $key => $plan)
                                        <option value="{{ $key }}">{{ trim(sprintf('%s: $%.02f %s', $plan['name'], $plan['price'], $plan['test'] ? '(TEST)' : '')) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="input-wrapper">
                            <label>Enter your domain:</label>
                            <div class="merged-input">
                                <input class="input-left" type="text" name="shop" placeholder="your-store"><input class="input-right" type="text" value=".myshopify.com" disabled>
                            </div>
                        </div>
                        <input type="submit" class="btn primary" value="Sign Up">

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection