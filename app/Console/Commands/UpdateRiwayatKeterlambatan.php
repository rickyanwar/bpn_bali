<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permohonan;
use App\Models\RiwayatKeterlambatan;
use App\Models\User;
use Carbon\Carbon;

class UpdateRiwayatKeterlambatan extends Command
{
    protected $signature = 'permohonan:update-keterlambatan';
    protected $description = 'Check and record delayed permohonan in riwayat_keterlambatan';

    public function handle()
    {
        // Fetch all permohonan with their riwayat
        $permohonans = Permohonan::with('riwayat')->get();

        // Preload special users to avoid querying inside the loop
        $indahCorry = User::where('name', 'Indah Corry')->first();
        $priskha    = User::where('name', 'Priskha Primamayanti')->first();

        foreach ($permohonans as $permohonan) {
            $latestRiwayat = $permohonan->riwayat()->latest()->first();

            // Skip if no riwayat or already selesai
            if (!$latestRiwayat || $permohonan->status == 'selesai') {
                continue;
            }

            // Skip if assigned to Indah or Priskha
            if (
                ($indahCorry && $latestRiwayat->diteruskan_ke == $indahCorry->id) ||
                ($priskha && $latestRiwayat->diteruskan_ke == $priskha->id)
            ) {
                continue;
            }

            $isPetugasUkur = $latestRiwayat->diteruskan_ke_role == "Petugas Ukur";
            $dateField = $isPetugasUkur
                ? Carbon::parse($permohonan->tanggal_mulai_pengukuran)
                : Carbon::parse($latestRiwayat->created_at);

            $daysThreshold = $isPetugasUkur ? 3 : 2;
            $isMoreThanThresholdDaysOld = $dateField->lt(Carbon::now()->subDays($daysThreshold));
            $statusIsNotSelesai = $latestRiwayat->status !== 'selesai';

            if ($isMoreThanThresholdDaysOld && $statusIsNotSelesai) {

                // Check if an identical record already exists
                $exists = RiwayatKeterlambatan::where('permohonan_id', $permohonan->id)
                    ->where('user_id', $latestRiwayat->diteruskan_ke)
                    ->where('tanggal_mulai_pengukuran', $permohonan->tanggal_mulai_pengukuran)
                    ->where('diteruskan_ke_role', $latestRiwayat->diteruskan_ke_role)
                    ->exists();

                if (!$exists) {
                    // Only create if no identical record exists
                    RiwayatKeterlambatan::create([
                        'permohonan_id' => $permohonan->id,
                        'user_id' => $latestRiwayat->diteruskan_ke,
                        'tanggal_mulai_pengukuran' => $permohonan->tanggal_mulai_pengukuran,
                        'tanggal_dialihkan' => Carbon::parse($latestRiwayat->created_at)->format('Y-m-d'),
                        'tanggal_keterlambatan' => now()->toDateString(),
                        'diteruskan_ke_role' => $latestRiwayat->diteruskan_ke_role,
                    ]);
                }
            }
        }

        $this->info('Riwayat keterlambatan updated.');
    }
}
