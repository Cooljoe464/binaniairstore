<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->uuid('id')->primary(); // <--- CORRECTED
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->uuid('id')->primary(); // <--- CORRECTED
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();
            if ($teams) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->uuid(config('permission.column_names.permission_pivot_key') ?: 'permission_id'); // <--- CORRECTED

            $table->string('model_type');
            $table->uuid($columnNames['model_morph_key']); // <--- CORRECTED
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign(config('permission.column_names.permission_pivot_key') ?: 'permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], config('permission.column_names.permission_pivot_key') ?: 'permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([config('permission.column_names.permission_pivot_key') ?: 'permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->uuid(config('permission.column_names.role_pivot_key') ?: 'role_id'); // <--- CORRECTED

            $table->string('model_type');
            $table->uuid($columnNames['model_morph_key']); // <--- CORRECTED
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign(config('permission.column_names.role_pivot_key') ?: 'role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], config('permission.column_names.role_pivot_key') ?: 'role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([config('permission.column_names.role_pivot_key') ?: 'role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->uuid(config('permission.column_names.permission_pivot_key') ?: 'permission_id'); // <--- CORRECTED
            $table->uuid(config('permission.column_names.role_pivot_key') ?: 'role_id'); // <--- CORRECTED

            $table->foreign(config('permission.column_names.permission_pivot_key') ?: 'permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign(config('permission.column_names.role_pivot_key') ?: 'role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([config('permission.column_names.permission_pivot_key') ?: 'permission_id', config('permission.column_names.role_pivot_key') ?: 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)->forget(config('permission.cache.key'));
    }

    public function down()
    {
        // ... (down method remains the same)
    }
};
