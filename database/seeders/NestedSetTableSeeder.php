<?php

use App\Models\NestedSetModel;
use Illuminate\Database\Seeder;
class NestedSetTableSeeder extends Seeder
{

/**
 * Run the database seeds.
 *
 * @return void
 */
public function run()
{
    $node = NestedSetModel::create([
            'name' => 'Root',
            'children' => [
                [
                    'name' => 'A',
                    'children' => [
                        ['name' => 'C'],
                    ],
                ],
            ],
    ]);
  }
}