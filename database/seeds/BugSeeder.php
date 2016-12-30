<?php

use Illuminate\Database\Seeder;

class BugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $img = ['/Uploads/bugs/20161229/1482973974969375.jpg', '/Uploads/bugs/20161229/1482974767869784.jpg'];
        $tmp = [];
        for ($i = 0; $i < 100; $i++) {
            $data['url'] = str_random(30);
            $data['title'] = str_random(20);
            $data['description'] = str_random(100);
            $d = rand(0, 1);
            $data['images'] = $img[$d];
            $data['creator_user_id'] = 3;
            $data['fixer_user_id'] = rand(4, 5);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $tmp[] = $data;
        }

        DB::table('bugs')->insert($tmp);
    }
}
