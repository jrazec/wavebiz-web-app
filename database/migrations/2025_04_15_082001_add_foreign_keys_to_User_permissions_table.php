<?php

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
        Schema::connection('admin_db')->table('User_permissions', function (Blueprint $table) {
            $table->foreign(['fldUserID'], 'user_permissions_ibfk_1')->references(['fldID'])->on('Users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fldPermissionID'], 'user_permissions_ibfk_2')->references(['fldID'])->on('Permissions')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_db')->table('User_permissions', function (Blueprint $table) {
            $table->dropForeign('user_permissions_ibfk_1');
            $table->dropForeign('user_permissions_ibfk_2');
        });
    }

    /*
    CREATE TABLE Deliveries (
    fldID BIGINT AUTO_INCREMENT PRIMARY KEY,
    fldOrderID BIGINT,
    fldDeliveryAddress VARCHAR(500) NOT NULL,
    fldDeliveryStatus VARCHAR(100) DEFAULT 'Pending',
    fldDeliveryDate DATETIME NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (fldOrderID) REFERENCES Orders(fldID)
);

CREATE TABLE Orders (
    fldID BIGINT AUTO_INCREMENT PRIMARY KEY,
    fldMemberID BIGINT,
    fldOrderDate DATETIME NOT NULL,
    fldTotalAmount DECIMAL(10,2) NOT NULL,
    fldPaymentStatus TINYINT DEFAULT 0,
    fldOrderStatus TINYINT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (fldMemberID) REFERENCES Members(fldID)
);
    */
};
