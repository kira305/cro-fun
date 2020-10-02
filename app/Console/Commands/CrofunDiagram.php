<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Headquarters_MST;
use App\Department_MST;
use App\Group_MST;
use App\Project_MST;
use App\Cost_MST;
use App\Diagram;
use App\Rule_action;
use Carbon\Carbon;
use Crofun;
class CrofunDiagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tree:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Crofun::checkProject();
        Crofun::checkCost();
        // Crofun::checkGroup();
        // Crofun::checkDepartment();
        // Crofun::checkHeadquarter();
    }




}
