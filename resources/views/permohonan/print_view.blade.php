<div class="modal-body d-flex flex-column align-items-center">
    @if (auth()->user()->hasRole('Petugas Jadwal'))
        <a target="_blank" href="{{ route('permohonan.print', $data->id) }}?type=pemberitahuan"
            class="btn btn-outline-primary mb-3" style="border-radius: 20px">Print Surat Pemberitahuan
            <i class="fas fa-print"></i></a>
    @endif

    @if (auth()->user()->hasRole('Petugas Cetak Surat Tugas') && !empty($data->diteruskan_ke))
        <div class="form-group">
            <select class="form-control" id="print-option" style="padding-right: 2rem; border-radius:20px">
                <option value="">Cetak Surat</option>
                <option value="tugas pengukuran">Surat Tugas Petugas Ukur</option>
                <option value="lampiran tugas pengukuran">Surat Tugas Pembantu Ukur</option>
                <option value="perintah kerja">Surat Perintah Kerja</option>
            </select>
        </div>
    @endif
</div>
