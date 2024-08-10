<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('cascade'); // Corrected
            $table->enum('status', ['Pending', 'Approved', 'Assigned', 'In Progress', 'Rejected', 'Cancelled','Awaiting Payment'])->default('Pending');
            $table->decimal('total_price', 10, 2);
            $table->integer('total_progress_percentage')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
