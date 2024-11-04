<form class="container" action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)



    {{-- User | Consultant --}}
    <div class="row mb-3">
        <input type="hidden" name="consultant_id" value="{{ $consultantId }}">
            <label for="user_id" class="form-label">{{ __('Select User') }}</label>
            <select name="user_id" id="user_id" class="form-control js-example-basic-single">
                <option value="">{{ __('Select User') }}</option>
                @foreach ($users as $user)
                    <option class="form-control" value="{{ $user->id }}"
                        {{ old('user_id', $reservation->user_id) == $user->id ? 'selected' : '' }}>
                        {{ __($user->name) }}
                    </option>
                @endforeach
            </select>
        
    </div>
    {{-- User | Consultant --}}

    {{-- Reservation Date | Start-End Time --}}

    <div class="mb-3">
        <label for="reservation_date" class="form-label">{{ __('Reservation Date') }}</label>
        <input class="form-control" type="date" name="reservation_date" id="reservation_date"
            value="{{ old('reservation_date', \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d')) }}"
            min="{{ now()->format('Y-m-d') }}" required>

    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="start_time" class="form-label">{{ __('Start Time') }}</label>
            <input class="form-control" type="time" name="start_time" id="start_time"
                value="{{ old('start_time', \Carbon\Carbon::parse($reservation->start_time)->format('H:i')) }}"
                required>
        </div>

        <div class="col">
            <label for="end_time" class="form-label">{{ __('End Time') }}</label>
            <input class="form-control" type="time" name="end_time" id="end_time"
                value="{{ old('end_time', \Carbon\Carbon::parse($reservation->end_time)->format('H:i')) }}" required>
        </div>
    </div>
    {{-- Reservation Date | Start-End Time --}}

    {{-- Estado de la Reserva y el Pago --}}
    <div class="row mb-3">
        <div class="col">
            <label for="reservation_status" class="form-label">{{ __('Reservation Status') }}</label>
            <select name="reservation_status" id="reservation_status" class="form-control js-example-basic-single">
                <option value="">{{ __('Reservation Status') }}</option>
                @foreach ($reservationStatuses as $reservationStatus)
                    <option class="form-control" value="{{$reservationStatus }}"
                        {{ old('reservation_status', $reservation->reservation_status) == $reservationStatus ? 'selected' : '' }}>
                        {{ __($reservationStatus) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <label for="payment_status" class="form-label">{{ __('Payment Status') }}</label>
            <select name="payment_status" id="payment_status" class="form-control js-example-basic-single">
                <option value="">{{ __('Payment Status') }}</option>
                @foreach ($paymentStatuses as $paymentStatus)
                    <option value="{{ $paymentStatus }}"
                        {{ old('payment_status', $reservation->payment_status) == $paymentStatus ? 'selected' : '' }}>
                        {{ __($paymentStatus) }} 
                    </option>
                @endforeach
            </select>
            
        </div>


    </div>
    {{-- Estado de la Reserva y el Pago --}}

        {{-- Total y Estado de la Cancelacion --}}
        <div class="row mb-3">
            <div class="col">
                <label for="total_amount" class="form-label">{{ __('Total Amount') }} (USD)</label>
                <input class="form-control" type="number" name="total_amount" id="total_amount"
                value="{{ old('total_amount', number_format($reservation->total_amount, 0, '', '')) }}"
                >
            </div>
    
            <div class="col">
                <label for="cancellation_reason" class="form-label">{{ __('Cancellation Reason') }}</label>
                <input class="form-control" type="text" name="cancellation_reason" id="cancellation_reason"
                    value="{{ old('cancellation_reason', $reservation->cancellation_reason) }}">
            </div>
        </div>
        {{-- Total y Estado de la Cancelacion --}}

    
    {{-- All Errors Div --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- All Errors Div --}}


    {{-- Action Buttons --}}
    <div class="mb-3 col">
        <button type="submit" class="btn btn-secondary">
            {{ $method == 'POST' ? __('Create') : __('Update') }}
        </button>

        <a href="{{ route('consultants.index') }}" class="btn btn-secondary">
            {{ __('Cancel') }}
        </a>
    </div>
    {{-- Action Buttons --}}


</form>
