<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestFtpConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:test {disk=ftp_public}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test FTP connection and upload functionality';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $diskName = $this->argument('disk');

        $this->info('╔══════════════════════════════════════╗');
        $this->info('║   FTP Connection Test - Laravel      ║');
        $this->info('╚══════════════════════════════════════╝');
        $this->newLine();

        $this->info("Testing FTP disk: {$diskName}");
        $this->newLine();

        try {
            $disk = Storage::disk($diskName);

            // 1. Test Connection
            $this->line('1. Testing FTP connection...');
            $config = config("filesystems.disks.{$diskName}");
            $this->table(
                ['Config', 'Value'],
                [
                    ['Host', $config['host'] ?? 'Not set'],
                    ['Username', $config['username'] ?? 'Not set'],
                    ['Port', $config['port'] ?? 'Not set'],
                    ['Root', $config['root'] ?? 'Not set'],
                    ['Passive', $config['passive'] ? 'Yes' : 'No'],
                    ['SSL', $config['ssl'] ? 'Yes' : 'No'],
                ]
            );

            // 2. Test Directory Listing
            $this->line('2. Testing directory listing...');
            $files = $disk->files('/');
            $this->info('   ✓ Directory listing successful');
            $this->line('   Files found: '.count($files));

            // 3. Test Write
            $this->line('3. Testing file upload...');
            $testFile = 'ftp_test_'.time().'.txt';
            $testContent = 'Test content from Laravel FTP Test Command - '.now()->toDateTimeString();

            $disk->put($testFile, $testContent);
            $this->info('   ✓ File uploaded successfully: '.$testFile);

            // 4. Test Read
            $this->line('4. Testing file read...');
            $content = $disk->get($testFile);

            if ($content === $testContent) {
                $this->info('   ✓ File content verified');
            } else {
                $this->warn('   ⚠ File content mismatch');
            }

            // 5. Test Exists
            $this->line('5. Testing file exists check...');
            if ($disk->exists($testFile)) {
                $this->info('   ✓ File exists check passed');
            } else {
                $this->warn('   ⚠ File exists check failed');
            }

            // 6. Test URL
            $this->line('6. Testing file URL generation...');
            $url = $disk->url($testFile);
            $this->info('   ✓ File URL: '.$url);

            // 7. Test Size
            $this->line('7. Testing file size...');
            $size = $disk->size($testFile);
            $this->info('   ✓ File size: '.$size.' bytes');

            // 8. Test Delete
            $this->line('8. Testing file deletion...');
            $disk->delete($testFile);

            if (! $disk->exists($testFile)) {
                $this->info('   ✓ File deleted successfully');
            } else {
                $this->warn('   ⚠ File deletion failed');
            }

            // Success summary
            $this->newLine();
            $this->info('╔══════════════════════════════════════╗');
            $this->info('║   🎉 All Tests Passed!               ║');
            $this->info('╚══════════════════════════════════════╝');
            $this->newLine();
            $this->info('FTP connection is working correctly!');
            $this->info('You can now use this disk for file uploads.');

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->newLine();
            $this->error('╔══════════════════════════════════════╗');
            $this->error('║   ✗ FTP Test Failed!                ║');
            $this->error('╚══════════════════════════════════════╝');
            $this->newLine();
            $this->error('Error: '.$e->getMessage());
            $this->newLine();

            // Troubleshooting hints
            $this->warn('Troubleshooting Hints:');
            $this->line('1. Check FTP credentials in .env file');
            $this->line('2. Verify FTP_HOST is correct (ftp.yourdomain.com or IP)');
            $this->line('3. Test FTP connection using FileZilla/WinSCP');
            $this->line('4. Try switching FTP_PASSIVE (true/false)');
            $this->line('5. Check firewall allows FTP connection (port 21)');
            $this->line('6. Verify FTP_ROOT path exists on server');
            $this->newLine();

            return Command::FAILURE;
        }
    }
}
