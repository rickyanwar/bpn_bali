{!! Html::form('put', route('users.update', $user->id))->open() !!}

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('Nama'), 'Nama')->class('form-label') !!}
                {!! Html::text('name', $user->name)->class('form-control')->placeholder(__('Masukkan User Name')) !!}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Html::label(__('NIK'), 'NIK')->class('form-label') !!}
                {!! Html::text('nik', $user->nik)->class('form-control')->placeholder(__('Masukkan nik')) !!}
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
                {!! Html::text('nip', $user->nip)->class('form-control')->placeholder(__('NIP')) !!}
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
                {!! Html::text('golongan', $user->golongan)->class('form-control')->placeholder(__('Masukkan golongan')) !!}
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
                {!! Html::text('jabatan', $user->jabatan)->class('form-control')->placeholder(__('Masukkan jabatan')) !!}
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
                {!! Html::text('no_hp', $user->no_hp)->class('form-control')->placeholder(__('Masukkan no hp')) !!}
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
                {!! Html::text('email', $user->email)->class('form-control')->placeholder(__('Masukkan User Email'))->required() !!}
                @error('email')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::label(__('User Role'))->class('form-label') !!}
            <select class="form-control select2" id="role" name="role">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" data-name="{{ $role->name }}"
                        {{ $user->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
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
                {!! Html::text('pembantu_ukur', $user->pembantu_ukur)->class('form-control')->id('pembantu_ukur')->placeholder(__('Masukkan Pembantu ukur')) !!}
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
                {!! Html::text('pembantu_ukur_nik', $user->pembantu_ukur_nik)->class('form-control')->id('pembantu_ukur_nik')->placeholder(__('Masukkan NIK Pembantu ukur')) !!}
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
                {!! Html::text('pembantu_ukur_no_sk', $user->pembantu_ukur_no_sk)->class('form-control')->id('pembantu_ukur_no_sk')->placeholder(__('Masukkan No SK/NIP Pembantu ukur')) !!}
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
                {!! Html::password('password')->class('form-control')->placeholder(__('Masukkan User Password'))->attribute('minlength', '6') !!}

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
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{!! Html::form()->close() !!}
