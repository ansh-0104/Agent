<?php

namespace App\Console\Commands;

use App\Models\Uploads;
use Illuminate\Console\Command;
use App\Models\User;
use League\Csv\Reader;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $uploads = Uploads::where('executed', 0)->get();

        foreach ($uploads as $upload) {
            $filename = public_path('store/' . $upload->file);
            $csv = Reader::createFromPath($filename, 'r');
            $csv->setHeaderOffset(0);
            $hobbies = ['Reading', 'Sports', 'Music'];
            $hobbiesString = implode(', ', $hobbies);
            $chunkSize = 100;

            $totalRecords = $csv->count();
            $processedRecords = 0;

            $csv->each(function ($record) use ($hobbiesString, $upload, &$processedRecords, $totalRecords) {
                // Check if the email already exists
                $existingUser = User::where('email', $record['Email'])->first();
                if (!$existingUser) {
                    try {
                        User::create([
                            'name' => $record['Name'],
                            'email' => $record['Email'],
                            'contact_number' => $record['Contact Number'],
                            'hobbies' => $record['Hobbies'],
                            'password' => 'password',
                            'address' => $record['Address'],
                            'city' => $record['City'],
                            'roles' => $record['Roles'],
                            'gender' => $record['Gender'],
                        ]);
                    } catch (Exception $e) {
                        // Handle any exceptions here, for example, log the error or display an error message
                        $this->error('An error occurred: ' . $e->getMessage());
                    }
                }

                // Update the progress for the upload
                $upload->progress = ++$processedRecords / $totalRecords * 100;
                $upload->save();
            }, $chunkSize);

            $upload->progress = 100;
            $upload->executed = 1;
            $upload->save();

            $this->info('Users imported successfully!');
        }
    }
}
