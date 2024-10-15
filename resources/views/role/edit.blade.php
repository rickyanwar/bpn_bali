{!! Html::modelForm($role, 'PUT', route('roles.update', $role->id))->open() !!}

<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {!! Html::label('name', __('Name'))->class('form-label') !!}
                {{--  {!! Html::text('name', ' Name')->value($role->name) !!}  --}}
                {!! Html::text('name', old('name'))->class('form-control')->placeholder(__('Enter Role Name')) !!}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="pills-home-tab">
                    @php
                        $modules = ['user', 'role', 'permohonan'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign General Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="form-check-input" name="staff_checkall"
                                                    id="staff_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input ischeck staff_checkall"
                                                        data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">
                                                </td>
                                                <td><label class="ischeck staff_checkall"
                                                        data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('View')->class('custom-control-label') !!}<br>

                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}
                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Add')->class('custom-control-label') !!} <br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">

                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Manage')->class('custom-control-label') !!} <br>

                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">

                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Create')->class('custom-control-label') !!} <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Edit')->class('custom-control-label') !!} <br>

                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Delete')->class('custom-control-label') !!} <br>

                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Show')->class('custom-control-label') !!} <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        {{--  {!! implode(', ', $permissions) !!}  --}}
                                                        @if (in_array('ambil ' . $module, (array) $permissions))
                                                            @if (($key = array_search('ambil ' . $module, $permissions)) !== false)
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace([' ', '&'], '', $module))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Ambil Permohonan ' . $module)->class('custom-control-label') !!}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>

{!! Html::closeModelForm() !!}

<script>
    $(document).ready(function() {
        $("#staff_checkall").click(function() {
            $('.staff_checkall').not(this).prop('checked', this.checked);
        });
        $("#crm_checkall").click(function() {
            $('.crm_checkall').not(this).prop('checked', this.checked);
        });
        $("#project_checkall").click(function() {
            $('.project_checkall').not(this).prop('checked', this.checked);
        });
        $("#hrm_checkall").click(function() {
            $('.hrm_checkall').not(this).prop('checked', this.checked);
        });
        $("#account_checkall").click(function() {
            $('.account_checkall').not(this).prop('checked', this.checked);
        });
        $("#pos_checkall").click(function() {
            $('.pos_checkall').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);
        });
    });
</script>
