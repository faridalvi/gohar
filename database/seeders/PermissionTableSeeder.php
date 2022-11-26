<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['permission-group-list',1],
            ['permission-group-create',1],
            ['permission-group-edit',1],
            ['permission-group-delete',1],
            ['permission-list',1],
            ['permission-create',1],
            ['permission-edit',1],
            ['permission-delete',1],
            ['role-list',2],
            ['role-create',2],
            ['role-edit',2],
            ['role-delete',2],
            ['user-list',2],
            ['user-create',2],
            ['user-edit',2],
            ['user-delete',2],
            ['dashboard',2],
            ['category-list',2],
            ['category-create',2],
            ['category-edit',2],
            ['category-delete',2],
            ['season-list',2],
            ['season-create',2],
            ['season-edit',2],
            ['season-delete',2],
            ['age-group-list',2],
            ['age-group-create',2],
            ['age-group-edit',2],
            ['age-group-delete',2],
            ['country-list',2],
            ['country-create',2],
            ['country-edit',2],
            ['country-delete',2],
            ['region-list',2],
            ['region-create',2],
            ['region-edit',2],
            ['region-delete',2],
            ['customer-list',2],
            ['customer-create',2],
            ['customer-edit',2],
            ['customer-delete',2],
            ['loom-type-list',2],
            ['loom-type-create',2],
            ['loom-type-edit',2],
            ['loom-type-delete',2],
            ['atribute-yarn-list',2],
            ['atribute-yarn-create',2],
            ['atribute-yarn-edit',2],
            ['atribute-yarn-delete',2],
            ['atribute-weaving-list',2],
            ['atribute-weaving-create',2],
            ['atribute-weaving-edit',2],
            ['atribute-weaving-delete',2],
            ['atribute-processing-list',2],
            ['atribute-processing-create',2],
            ['atribute-processing-edit',2],
            ['atribute-processing-delete',2],
            ['atribute-stitching-list',2],
            ['atribute-stitching-create',2],
            ['atribute-stitching-edit',2],
            ['atribute-stitching-delete',2],
            ['fabric-type-list',2],
            ['fabric-type-create',2],
            ['fabric-type-edit',2],
            ['fabric-type-delete',2],
            ['product-list',2],
            ['product-create',2],
            ['product-edit',2],
            ['product-delete',2],
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['0'],'group_id'=>$permission[1]]);
        }
    }
}
