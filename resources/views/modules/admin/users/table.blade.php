<table class="table table-dark table-striped" id="table">

    <thead>
        <tr>
            <th >{{__('Actions')}}</th>
            <th >ID</th>
            <th >{{__('Name')}}</th>
            <th >{{__('Lastname')}}</th>
            <th >{{__('Email')}}</th>
            <th >{{__('Phone')}}</th>
            <th >{{__('Image')}}</th>
            <th >{{__('Role')}}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
        <tr>
            <td>
                <form action="{{ route('admin.users.destroy',$user) }}"
                
                method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')

                    <a href="{{ route('admin.users.show',$user) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estas Seguro?')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
            <td>{{ $user->id }}</td>
            <td>
                <a href="{{ route('admin.users.show',$user) }}">
                    {{ $user->name }}
                </a>
            </td>
            <td>{{ $user->userDetail->lastname }}</td>
            <td>
                <a href="{{ route('admin.users.show',$user) }}">
                    {{ $user->email }}
                </a>

            </td>
            <td>{{ $user->userDetail->phone }}</td>
            <td>
                
            @if ($user->userDetail->image)
            <img src="{{ asset('assets/img/users/' . $user->userDetail->image) }}" alt="{{ $user->name }}"
            class="img-fluid img-thumbnail rounded-circle" style="width: 50px">
                @else
                <span>{{__('No Image')}}</span>
            @endif
            
             </td>
            <td class="text-uppercase">{{ __($user->role->name) }}</td>

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
