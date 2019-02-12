<?php

use Illuminate\Database\Seeder;
use App\Vehicle;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = new Vehicle;
        $t->name = 'i10';
        $t->description = 'HYUNDAI I10 GLS 1.2L AT';
        $t->save();
        
        $t = new Vehicle;
        $t->name = 'HI-ACE';
        $t->description = 'HIACE COMMUTER VAN';
        $t->save();
        
        $t = new Vehicle;
        $t->name = 'AZERA';
        $t->description = 'AZERA 3.0GLS A, 2015';
        $t->save();
        
        $t = new Vehicle;
        $t->name = 'SONATA';
        $t->description = 'SONATA THETA II';
        $t->save();
        
        $t = new Vehicle;
        $t->name = 'KIA CARNIVAL';
        $t->description = 'KIA Carnival';
        $t->save();
        
        $t = new Vehicle;
        $t->name = 'ACCENT';
        $t->description = 'HYUNDAI Accent CVVT 1.4, 2011';
        $t->save();
        
        $t = new Vehicle;
        $t->name = 'CAMRY';
        $t->description = 'Camry 2.4V A/T, 2004';
        $t->save();
        
    }
}
