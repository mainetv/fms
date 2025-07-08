<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop foreign keys referencing user_roles.id
        DB::statement('ALTER TABLE model_has_user_roles DROP FOREIGN KEY model_has_user_roles_role_id_foreign');
        DB::statement('ALTER TABLE user_role_has_permissions DROP FOREIGN KEY user_role_has_permissions_role_id_foreign');
        DB::statement('ALTER TABLE users DROP FOREIGN KEY users_user_role_id_foreign');

        // Modify id column (remove auto_increment)
        DB::statement('ALTER TABLE user_roles MODIFY COLUMN id BIGINT UNSIGNED NOT NULL');

        // Re-add foreign keys
        DB::statement('ALTER TABLE model_has_user_roles 
        ADD CONSTRAINT model_has_user_roles_role_id_foreign 
        FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE CASCADE');

        DB::statement('ALTER TABLE user_role_has_permissions 
        ADD CONSTRAINT user_role_has_permissions_role_id_foreign 
        FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE CASCADE');

        DB::statement('ALTER TABLE users 
        ADD CONSTRAINT users_user_role_id_foreign 
        FOREIGN KEY (user_role_id) REFERENCES user_roles(id) ON DELETE SET NULL');
    }

    public function down()
    {
        // Drop foreign keys
        DB::statement('ALTER TABLE model_has_user_roles DROP FOREIGN KEY model_has_user_roles_role_id_foreign');
        DB::statement('ALTER TABLE user_role_has_permissions DROP FOREIGN KEY user_role_has_permissions_role_id_foreign');
        DB::statement('ALTER TABLE users DROP FOREIGN KEY users_user_role_id_foreign');

        // Add auto_increment back
        DB::statement('ALTER TABLE user_roles MODIFY COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        // Re-add foreign keys
        DB::statement('ALTER TABLE model_has_user_roles 
        ADD CONSTRAINT model_has_user_roles_role_id_foreign 
        FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE CASCADE');

        DB::statement('ALTER TABLE user_role_has_permissions 
        ADD CONSTRAINT user_role_has_permissions_role_id_foreign 
        FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE CASCADE');

        DB::statement('ALTER TABLE users 
        ADD CONSTRAINT users_user_role_id_foreign 
        FOREIGN KEY (user_role_id) REFERENCES user_roles(id) ON DELETE SET NULL');
    }
};
