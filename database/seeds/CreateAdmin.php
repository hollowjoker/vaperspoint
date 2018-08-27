<?php

use Illuminate\Database\Seeder;

use App\Models\Tbl_admin;

class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('tbl_admins')->truncate();

        $file_handle = fopen(__DIR__.'/csv/CreateAdmin.csv','r');

        while(!feof($file_handle)) {
            $array[] = fgetcsv($file_handle, 1024);
        };
        fclose($file_handle);

        foreach($array as $key => $arr) {

            if($key != 0 && $arr != false) {

                $admin = new Tbl_admin();
                $admin->admin_name = $arr[0];
                $admin->username = $arr[1];
                $admin->password = bcrypt($arr[2]);
                $admin->type = $arr[3];
                $admin->status = $arr[4];

                $admin->save();
            }

        }
    }
}
