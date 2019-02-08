<?php

use Illuminate\Database\Seeder;
use App\VehicleApprovalType;

class VehicleApprovalTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = new VehicleApprovalType;
        $t->name = 'Immediate Superior';
        $t->save();

        $t = new VehicleApprovalType;
        $t->name = 'Dept. Head/Mngr';
        $t->save();

        $t = new VehicleApprovalType;
        $t->name = 'HRAD';
        $t->save();

        $t = new VehicleApprovalType;
        $t->name = 'General Manager';
        $t->save();
    }
}
