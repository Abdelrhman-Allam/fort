<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RinvexFortAbilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(config('rinvex.fort.tables.abilities'))->truncate();

        // Get abilities data
        $abilities = require __DIR__.'/../../resources/data/abilities.php';

        // Create new abilities
        foreach ($abilities as $ability) {
            app('rinvex.fort.ability')->create($ability);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
