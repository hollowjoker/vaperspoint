<?php

use Illuminate\Database\Seeder;
use App\Models\Tbl_user;

class CreateUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('tbl_users')->truncate();

        $file_handle = fopen(__DIR__.'/csv/CreateUser.csv','r');

        while(!feof($file_handle)) {
            $array[] = fgetcsv($file_handle, 1024);
        };
        fclose($file_handle);

        foreach($array as $key => $arr) {

            if($key != 0 && $arr != false) {

                $admin = new Tbl_user();
                $admin->user_name = $arr[0];
                $admin->password = bcrypt($arr[1]);

                $admin->save();
            }

        }
    }
}
