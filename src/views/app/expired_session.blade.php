@extends('shopify::stand_alone')

@section('title', 'Session has expired')

@section('content')
    <div class="section">
        <div class="section-content">
            <div class="section-row">
                <div class="section-cell">
                    <div class="box warning"><i class="ico-warning"></i>
                        Your session has expired!
                        <p>Please refresh your browser to log back in!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
