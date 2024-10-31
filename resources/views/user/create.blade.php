{!! Html::form('post', '/users')->open() !!}

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Nama'), 'Nama')->class('form-label') !!}
                {!! Html::text('name')->class('form-control')->placeholder(__('Masukkan User Name'))->required() !!}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('NIK/NO SK'), 'NIK/NO SK')->class('form-label') !!}
                {!! Html::text('nik')->class('form-control')->placeholder(__('Masukkan NIP/NO SK')) !!}
                @error('nik')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! Html::label(__('NIP'), 'NIP')->class('form-label') !!}
                {!! Html::text('nip')->class('form-control')->placeholder(__('NIP')) !!}
                @error('nip')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! Html::label(__('Golongan'), 'Golongan')->class('form-label') !!}
                {!! Html::text('golongan')->class('form-control')->placeholder(__('Masukkan golongan')) !!}
                @error('golongan')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Jabatan'), 'Jabatan')->class('form-label') !!}
                {!! Html::text('jabatan')->class('form-control')->placeholder(__('Masukkan jabatan')) !!}
                @error('jabatan')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('No Hp'), 'No Hp')->class('form-label') !!}
                {!! Html::text('no_hp')->class('form-control')->placeholder(__('Masukkan no hp'))->required() !!}
                @error('no_hp')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Email'), 'email')->class('form-label') !!}
                {!! Html::text('email')->class('form-control')->placeholder(__('Masukkan User Email')) !!}

                @error('email')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-6">
            <style>
                .select2-container {
                    z-index: 2050;
                    /* Adjust as necessary to be higher than the modal */
                }
            </style>
            {!! Html::label(__('User Role'))->class('form-label') !!}
            <select class="form-control select2" id="role" name="role">
                @foreach ($roles as $id => $name)
                    <option value="{{ $id }}" data-name="{{ $name }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
            @enderror
        </div>

        <!-- Additional Pendamping Select (Hidden by Default) -->
        <div class="col-md-6 pendamping-container" style="display: none">
            <div class="form-group pendamping-container">
                {!! Html::label(__('Pembantu Ukur'))->class('form-label') !!}
                {!! Html::text('pembantu_ukur')->class('form-control')->id('pembantu_ukur')->placeholder(__('Masukkan Pembantu ukur')) !!}
                @error('pendamping_id')
                    <small class="invalid-user" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 pendamping-container">
            <div class="form-group">
                {!! Html::label(__('Pembantu Ukur NIK'))->class('form-label') !!}
                {!! Html::text('pembantu_ukur_nik')->class('form-control')->id('pembantu_ukur_nik')->placeholder(__('Masukkan NIK Pembantu ukur')) !!}
                @error('pendamping_id')
                    <small class="invalid-user" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 pendamping-container">
            <div class="form-group">
                {!! Html::label(__('Pembantu Ukur No SK'))->class('form-label') !!}
                {!! Html::text('pembantu_ukur_no_sk', '')->class('form-control')->id('pembantu_ukur_no_sk')->placeholder(__('Masukkan Pembantu ukur NIP/No SK')) !!}
                @error('pembantu_ukur_no_sk')
                    <small class="invalid-user" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Password'), 'password')->class('form-label') !!}
                {!! Html::password('password')->class('form-control')->placeholder(__('Masukkan User Password'))->required()->attribute('minlength', '6') !!}

                @error('password')
                    <small class="invalid-password" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
    </div>
    {!! Html::form()->close() !!}
