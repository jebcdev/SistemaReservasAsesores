<form class="container" action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{-- Image if Exists --}}
    @if ($user->userDetail && $user->userDetail->image)
        <div class="mb-3 text-center rounded">
            <img src="{{ asset('assets/img/users/' . $user->userDetail->image) }}" alt="{{ $user->name }}"
                class="img-fluid img-thumbnail rounded-circle" style="width: 200px">
        </div>
    @endif
    {{-- Image if Exists --}}


    {{-- Name LastName --}}
    <div class="row mb-3">
        <div class="col">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="col">
            <label for="lastname" class="form-label">{{ __('Lastname') }}</label>
            <input type="text" class="form-control" id="lastname" name="lastname"
                value="{{ old('lastname', $user->userDetail->lastname ?? '') }}" required>
        </div>


    </div>
    {{-- Name LastName --}}

    {{-- Phone Email --}}
    <div class="row">
        <div class="col">
            <label for="phone" class="form-label">{{ __('Phone') }}</label>
            <input type="text" class="form-control" id="phone" name="phone"
                value="{{ old('phone', $user->userDetail->phone ?? '') }}" required>
        </div>
        <div class="col">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $user->email) }}" required>
        </div>
    </div>
    {{-- Phone Email --}}

    {{-- Password And Confirmation --}}
    <div class="row mb-3">
        <div class="col">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"
                {{ $method == 'POST' ? 'required' : '' }}>
        </div>
        <div class="col">
            <label for="password_confirmation" class="form-label">{{ __('Password Confirmation') }}</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                value="{{ old('password_confirmation') }}"{{ $method == 'POST' ? 'required' : '' }}>
        </div>
    </div>
    {{-- Password And Confirmation --}}

    {{-- Image and Role --}}
    <div class="row mb-3">
        <div class="col">
            <label for="image" class="form-label">{{ __('Image') }} ({{__('Optional')}})</label>
            <input class="form-control" type="file" id="image" name="image"
                value="{{ old('image', $user->userDetail->image ?? '') }}">
        </div>

        @if ($user->id != 1)
            <div class="col">
                <label for="role_id" class="form-label">{{ __('Role') }}</label>
                <select name="role_id" id="role_id" class="form-control text-uppercase">
                    <option value="">{{ __('Select Role') }}</option>
                    @foreach ($roles as $role)
                        <option class="text-uppercase" value="{{ $role->id }}"
                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ __($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="role_id" value="1">
        @endif
    </div>

    {{-- Image and Role --}}


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

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            {{ __('Cancel') }}
        </a>
    </div>
    {{-- Action Buttons --}}


</form>
