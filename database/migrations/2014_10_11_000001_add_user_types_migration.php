<?php

use App\Models\LkUserType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user_type = new LkUserType();
        $user_type->code = LkUserType::ADMIN;
        $user_type->description = "Administrator User";
        $user_type->save();

        $user_type = new LkUserType();
        $user_type->code = LkUserType::CUSTOMER;
        $user_type->description = "Customer User";
        $user_type->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
