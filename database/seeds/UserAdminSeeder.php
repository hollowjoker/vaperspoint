<?php

use Illuminate\Database\Seeder;

use App\Models\User_admin;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('user_admin')->truncate();

        $file_handle = fopen(__DIR__.'/csv/CreateAdmin.csv','r');

        while(!feof($file_handle)) {
            $array[] = fgetcsv($file_handle, 1024);
        };
        fclose($file_handle);

        foreach($array as $key => $arr) {

            if($key != 0 && $arr != false) {

                $admin = new User_admin();
                $admin->type = $arr[0];
                $admin->username = $arr[1];
                $admin->password = bcrypt($arr[2]);
                $admin->email = $arr[3];
                $admin->name = $arr[4];

                $admin->save();
            }

        }
    }
}
