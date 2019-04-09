<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\MachineMaster;

class MachineOwnership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjs:owned {database=bjs_5c1b940ad503a31f360e1252}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add field owned_by_bjs to machines';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
			$recordCount = 0;
			$dbName = $this->argument('database');

			$mongoDBConfig = config('database.connections.mongodb');
			$mongoDBConfig['database'] = $dbName;
			\Illuminate\Support\Facades\Config::set(
				'database.connections.' . $dbName,
				$mongoDBConfig
			);
			DB::setDefaultConnection($dbName);

			$filePath = public_path('master-data/bjs_owned_machine_list.csv');
			$data = $this->csvToArray($filePath);

			$this->info('The operation has started...');
			foreach ($data as $machine) {
				MachineMaster::where('machine_code', $machine['machine_code'])->update(['owned_by_bjs' => true]);
				$recordCount++;
			}
			$this->info($recordCount . ' records have been updated.');
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
    }

	private function csvToArray($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
