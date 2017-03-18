@extends('shopify::embedded')

@section('title', 'Plans')

@section('content')
    <div class="section">
        <div class="section-summary">
            <h1>Plans</h1>
            <p>View available plans</p>
        </div>
        <div class="section-content">
            <div class="section-row">
                <div class="section-cell">
                    <form action="{{ route('shopify.plan.create') }}">

                        {{ csrf_field() }}
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

                        <input type="submit" class="btn primary" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-summary">
            <h1>History</h1>
            <p>Billing history</p>
        </div>
        <div class="section-content">
            <div class="section-row">
                <div class="section-cell">
                    <table class="table-section">
                        <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Price ($)</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plans_history as $plan)
                        <tr>
                            <td>{{ $plan['name'] }}</td>
                            <td>{{ $plan['price'] }}</td>
                            <td>{{ ucfirst($plan['status']) . ( ($plan['status'] == 'cancelled') ? ( ' on ' . date('F d, Y', strtotime($plan['cancelled_on']))) : '') }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection