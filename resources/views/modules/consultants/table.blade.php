<table class="table table-dark table-striped" id="table">

    <thead>
        <tr>
            <th>{{ __('Actions') }}</th>
            <th>ID</th>
            <th>{{ __('User') }}</th>
            <th>{{ __('Cosultant') }}</th>
            <th>{{ __('Reservation Date') }}</th>
            <th>{{ __('Start Time') }}</th>
            <th>{{ __('End Time') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Total Amount') }}</th>
            <th>{{ __('Payment Status') }}</th>

        </tr>
    </thead>
    <tbody>
        @forelse ($reservations as $reservation)
            <tr>
                <td>
                    @if ($reservation->reservation_status == 'CANCELADA')
                        <span class="btn btn-sm btn-secondary">{{ __($reservation->reservation_status) }}</span>
                    @else
                        <form action="{{ route('consultants.destroy', $reservation) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('consultants.edit', $reservation) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estas Seguro?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif
                </td>

                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->consultant->name ?? '' }}</td>
                <td>

                    {{ $reservation->reservation_date->format('d-m-Y') }}

                </td>
                <td>{{ $reservation->start_time->format('H:i') }}</td>
                <td>{{ $reservation->end_time->format('H:i') }}</td>
                <td>
                    @switch($reservation->reservation_status)
                        @case('PENDIENTE')
                            <span class="btn btn-sm btn-warning">{{ __($reservation->reservation_status) }}</span>
                        @break

                        @case('CONFIRMADA')
                            <span class="btn btn-sm btn-success">{{ __($reservation->reservation_status) }}</span>
                        @break

                        @case('PAGADA')
                            <span class="btn btn-sm btn-primary">{{ __($reservation->reservation_status) }}</span>
                        @break

                        @default
                            <span class="btn btn-sm btn-secondary">{{ __($reservation->reservation_status) }}</span>
                    @endswitch
                </td>
                <td>{{ $reservation->total_amount }}</td>
                <td>{{ $reservation->payment_status }}</td>



            </tr>
            @empty
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            @endforelse

        </tbody>
    </table>
