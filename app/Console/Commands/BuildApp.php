<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BuildApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build aplikasi dan migrasi table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        passthru('npm install', $exitCode);
        if ($exitCode === 0) {
            $this->info('Instalasi dependensi npm berhasil');
        } else {
            $this->error('Error occurred while running : npm install!');
        }
        passthru('npm run build', $exitCode);
        if ($exitCode === 0) {
            $this->info('Build resources berhasil !!');
        } else {
            $this->error('Error occurred while running : npm run build!');
        }

        // Copy .env file
        if (!file_exists('.env')) {
            // copy('.env', '.env.backup'); // Backup existing .env file
            copy('.env.example', '.env');
            $this->info('Generating application key...');
            sleep(5);
            $this->call('key:generate');
        } else {
            $this->error('.env already exist..!');
        }

        // Execute php artisan migrate
        passthru('php artisan migrate --seed', $exitCode);

        // Periksa kode keluaran (exit code) untuk mengetahui apakah perintah berhasil dijalankan
        if ($exitCode === 0) {
            $this->info('Migration completed successfully!');
        } else {
            $this->error('Error occurred while running : migration!');
        }
    }
}
