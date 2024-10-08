<div class="modal-body">
    <form id="form-teruskan">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="form-group">
                    <label class="form-label">Teruskan Ke
                    </label>
                    <select class="form-control form-control teruskan_ke_role" name="teruskan_ke_role"
                        id="teruskan_ke_role" style="width: 100%">
                        <option value="">Pilih</option>
                        @foreach ($allowedRoles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-10 mt-2" id="user-selection">
                <div class="form-group">
                    <h6>Pilih Petugas</h6>
                    <select class="form-control" id="user" name="user">

                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <button class="btn  btn-primary " id="btn-submit-teruskan">Alihkan</button>
</div>
