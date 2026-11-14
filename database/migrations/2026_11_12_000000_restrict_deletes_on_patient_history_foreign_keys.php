<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['department_id']);
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->restrictOnDelete();
        });

        Schema::table('doctor_schedules', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->restrictOnDelete();
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_schedule_id']);
            $table->foreign('patient_id')->references('id')->on('patients')->restrictOnDelete();
            $table->foreign('doctor_schedule_id')->references('id')->on('doctor_schedules')->restrictOnDelete();
        });

        Schema::table('queues', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->foreign('registration_id')->references('id')->on('registrations')->restrictOnDelete();
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->foreign('registration_id')->references('id')->on('registrations')->restrictOnDelete();
        });

        Schema::table('control_schedule_histories', function (Blueprint $table) {
            $table->dropForeign(['medical_record_id']);
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['department_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
        });

        Schema::table('doctor_schedules', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_schedule_id']);
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('doctor_schedule_id')->references('id')->on('doctor_schedules')->cascadeOnDelete();
        });

        Schema::table('queues', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->foreign('registration_id')->references('id')->on('registrations')->cascadeOnDelete();
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->foreign('registration_id')->references('id')->on('registrations')->cascadeOnDelete();
        });

        Schema::table('control_schedule_histories', function (Blueprint $table) {
            $table->dropForeign(['medical_record_id']);
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->cascadeOnDelete();
        });
    }
};
