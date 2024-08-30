{!! Html::form('post', '/users')->open() !!}

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Name'), 'Name')->class('form-label') !!}
                {!! Html::text('name')->class('form-control')->placeholder(__('Enter User Name'))->required() !!}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Email'), 'email')->class('form-label') !!}
                {!! Html::text('email')->class('form-control')->placeholder(__('Enter User Email'))->required() !!}

                @error('email')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        @if (\Auth::user()->type != 'super admin')
            <div class="form-group col-md-6">
                <style>
                    .select2-container {
                        z-index: 2050;
                        /* Adjust as necessary to be higher than the modal */
                    }
                </style>
                {!! Html::label(__('User Role'))->class('form-label') !!}
                {!! Html::select('role', $roles)->class('form-control select2')->required() !!}
                @error('role')
                    <small class="invalid-role" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        @elseif(\Auth::user()->type == 'super admin')
            {!! Html::hidden('role', 'company', ['class' => 'form-control select2', 'required' => 'required']) !!}
        @endif
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Password'), 'password')->class('form-label') !!}
                {!! Html::password('password')->class('form-control')->placeholder(__('Enter User Password'))->required()->attribute('minlength', '6') !!}

                @error('password')
                    <small class="invalid-password" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{!! Html::form()->close() !!}
