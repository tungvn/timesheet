<?php

use Illuminate\Database\Seeder;

class CreateDefaultOAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->where('personal_access_client', 1)->update([
            'id'     => 'a9d26ed9-abb9-4582-b8bd-2998a10fc6c7',
            'secret' => 'VfTtHS8UCLtQpLeDgdnMLDlOtlziZmFvaniiVQFW',
        ]);

        DB::table('oauth_clients')->where('password_client', 1)->update([
            'id'     => 'b45ce90e-63a0-45a7-a73d-6c7523e06be1',
            'secret' => 'xjPdb7F7LMCtqKCuJFrAc0pp1gZydWRfjwoSqxsG',
        ]);
    }
}
