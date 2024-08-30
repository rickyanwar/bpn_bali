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
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-staff-tab" data-bs-toggle="pill" href="#staff" role="tab"
                        aria-controls="pills-home" aria-selected="true">{{ __('Staff') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-crm-tab" data-bs-toggle="pill" href="#crm" role="tab"
                        aria-controls="pills-profile" aria-selected="false">{{ __('CRM') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-project-tab" data-bs-toggle="pill" href="#project" role="tab"
                        aria-controls="pills-contact" aria-selected="false">{{ __('Project') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-hrmpermission-tab" data-bs-toggle="pill" href="#hrmpermission"
                        role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('HRM') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#account" role="tab"
                        aria-controls="pills-contact" aria-selected="false">{{ __('Account') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#pos" role="tab"
                        aria-controls="pills-contact" aria-selected="false">{{ __('POS') }}</a>
                </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="pills-home-tab">
                    @php
                        $modules = [
                            'user',
                            'role',
                            'client',
                            'product & service',
                            'constant unit',
                            'constant tax',
                            'constant category',
                            'company settings',
                        ];
                        if (\Auth::user()->type == 'company') {
                            $modules[] = 'permission';
                        }
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

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">

                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Move')->class('custom-control-label') !!}
                                                                    <br>
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


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}

                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Send')->class('custom-control-label') !!} <br>

                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}
                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Create Payment')->class('custom-control-label') !!} <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}
                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Delete Payment')->class('custom-control-label') !!} <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}
                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Income')->class('custom-control-label') !!} <br>

                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{-- Checkbox input --}}
                                                                    {!! Html::checkbox('permissions[]', $role->permissions->contains('id', $key), $key)->class('form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)))->id('permission' . $key) !!}
                                                                    {{-- Label for the checkbox --}}
                                                                    {!! Html::label('Expense')->class('custom-control-label') !!} <br>

                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $role->permissions->contains('id', $key), $key, ['class' => 'form-check-input isscheck staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('Tax', ['class' => 'custom-control-label']) }}<br>
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
