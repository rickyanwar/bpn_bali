<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class DatabaseBackupController extends Controller
{
    /**
     * Password akses halaman download database.
     * Bisa dioverride lewat env DB_BACKUP_PASSWORD.
     */
    protected function accessPassword(): string
    {
        return env('DB_BACKUP_PASSWORD', 'smartBPN123@');
    }

    public function index()
    {
        return view('database.download');
    }

    public function download(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!hash_equals($this->accessPassword(), $request->input('password'))) {
            return back()->withErrors(['password' => 'Password salah, akses ditolak.']);
        }

        $connection = config('database.default');
        $config     = config("database.connections.$connection");

        $fileName = $config['database'] . '_backup_' . date('Y-m-d_His') . '.sql';
        $dir      = storage_path('app/backups');
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $command = [
            $this->mysqldumpBinary(),
            '--host=' . $config['host'],
            '--port=' . ($config['port'] ?? 3306),
            '--user=' . $config['username'],
            '--single-transaction',
            '--triggers',
            '--result-file=' . $filePath,
            $config['database'],
        ];

        $process = new Process($command, null, [
            'MYSQL_PWD' => $config['password'] ?? '',
        ]);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful() || !file_exists($filePath)) {
            @unlink($filePath);

            return back()->withErrors([
                'password' => 'Gagal membuat backup database: ' . $process->getErrorOutput(),
            ]);
        }

        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Cari binary mysqldump karena web server belum tentu punya PATH lengkap.
     */
    protected function mysqldumpBinary(): string
    {
        $candidates = [
            env('MYSQLDUMP_PATH'),
            '/Applications/XAMPP/bin/mysqldump',
            '/usr/local/mysql/bin/mysqldump',
            '/opt/homebrew/bin/mysqldump',
            '/usr/bin/mysqldump',
        ];

        foreach ($candidates as $path) {
            if ($path && is_executable($path)) {
                return $path;
            }
        }

        return 'mysqldump';
    }
}
