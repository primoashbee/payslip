<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('employement')->nullable();
            $table->string('applicable')->nullable();
            $table->double('monthly_rate')->nullable();
            $table->double('daily_rate')->nullable();
            $table->integer('days_worked')->nullable();
            $table->double('earned')->nullable();
            $table->integer('days_absent')->nullable();
            $table->double('days_absent_amount')->nullable();
            $table->integer('minutes_tardiness')->nullable();
            $table->double('minutes_tardiness_amount')->nullable();
            $table->double('retro')->nullable();
            
            $table->double('gross_compensation')->nullable();
            $table->integer('addtional_holiday')->nullable();
            $table->double('addtional_holiday_amount')->nullable();
            $table->double('overtime_amount')->nullable();
            
            $table->double('taxable_compensation')->nullable();
            
            $table->double('rice_subsidy')->nullable();
            $table->double('account_payable')->nullable();
            $table->string('account_payable_remarks')->nullable();
            $table->string('other')->nullable();
            $table->double('other_additions_amount')->nullable();
            $table->double('total_additions')->nullable();
            
            $table->double('gross_pay')->nullable();

            $table->double('withholding_tax')->nullable();
            $table->double('sss_contribution')->nullable();
            $table->double('phic_contribution')->nullable();
            $table->double('hdmf_contribution')->nullable();

            $table->double('coop_scc')->nullable();
            $table->double('coop_savings')->nullable();
            $table->double('coop_loans')->nullable();

            $table->double('sss_loan')->nullable();
            $table->double('hdmf_loan')->nullable();
            $table->double('hdmf_mp2')->nullable();
            
            
            $table->double('ar')->nullable();
            $table->string('ar_remarks')->nullable();

            $table->double('total_deductions')->nullable();
            $table->double('net_pay')->nullable();
            $table->integer('date_received')->nullable();
            $table->date('start_date')->nullable();
            $table->date('cut_off_date')->nullable();
            $table->string('batch_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('seen_at')->nullable();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
