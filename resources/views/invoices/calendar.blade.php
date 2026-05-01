@extends('layout')
@section('title', 'Invoices Calendar')
@section('content')

<div class="card shadow-sm border-0 rounded p-3">
    <h4 class="mb-3">Invoices Calendar 2026</h4>

    <div class="calendar-year">

        @php
        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];
        @endphp

        <div class="row">
            @foreach($months as $index => $month)
            <div class="col-md-3 mb-4">
                <div class="calendar-month border p-2">
                    <h6 class="text-center">{{ $month }}</h6>
                    <table class="table table-sm table-bordered text-center mb-0">
                        <thead>
                            <tr>
                                <th>S</th>
                                <th>M</th>
                                <th>T</th>
                                <th>W</th>
                                <th>T</th>
                                <th>F</th>
                                <th>S</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $firstDay = \Carbon\Carbon::create(2026, $index+1, 1);
                                $daysInMonth = $firstDay->daysInMonth;
                                $startDay = $firstDay->dayOfWeek;
                                $day = 1;
                            @endphp

                            @for($week=0; $week<6; $week++)
                                <tr>
                                @for($dow=0; $dow<7; $dow++)
                                    @if($week==0 && $dow<$startDay)
                                        <td></td>
                                    @elseif($day > $daysInMonth)
                                        <td></td>
                                    @else
                                        @php
                                            $date = \Carbon\Carbon::create(2026, $index+1, $day)->format('Y-m-d');

                                            $invoicesToday = $invoices->where('invoice_date', $date);

                                            $hasUnpaid = $invoicesToday->contains(function($inv){
                                                return $inv->status == 'unpaid';
                                            });
                                        @endphp

                                        @if($hasUnpaid)
                                            <td class="bg-danger text-white">
                                                <a href="{{ route('invoices.unpaidByDate', $date) }}"
                                                   style="color:white; text-decoration:none; display:block;">
                                                    {{ $day }}
                                                </a>
                                            </td>
                                        @else
                                            <td>{{ $day }}</td>
                                        @endif

                                        @php $day++; @endphp
                                    @endif
                                @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

<style>
.calendar-year .calendar-month {
    background: #f9f9f9;
    border-radius: 5px;
}
.calendar-year table th {
    font-size: 0.8rem;
}
.calendar-year table td {
    height: 35px;
    width: 35px;
    font-size: 0.85rem;
    vertical-align: middle;
    cursor: pointer;
}
.bg-danger {
    background-color: #dc3545 !important;
    color: white;
}
</style>
