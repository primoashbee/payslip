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
            $table->float('monthly_rate')->nullable();
            $table->float('daily_rate')->nullable();
            $table->integer('days_worked')->nullable();
            $table->float('earned')->nullable();
            $table->integer('days_absent')->nullable();
            $table->float('days_absent_amount')->nullable();
            $table->integer('minutes_tardiness')->nullable();
            $table->float('minutes_tardiness_amount')->nullable();
            $table->float('retro')->nullable();
            
            $table->float('gross_compensation')->nullable();
            $table->integer('addtional_holiday')->nullable();
            $table->float('addtional_holiday_amount')->nullable();
            $table->float('overtime_amount')->nullable();
            
            $table->float('taxable_compensation')->nullable();
            
            $table->float('rice_subsidy')->nullable();
            $table->float('account_payable')->nullable();
            $table->string('account_payable_remarks')->nullable();
            $table->string('other')->nullable();
            $table->float('other_additions_amount')->nullable();
            $table->float('total_additions')->nullable();
            
            $table->float('gross_pay')->nullable();

            $table->float('withholding_tax')->nullable();
            $table->float('sss_contribution')->nullable();
            $table->float('phic_contribution')->nullable();
            $table->float('hdmf_contribution')->nullable();

            $table->float('coop_scc')->nullable();
            $table->float('coop_savings')->nullable();
            $table->float('coop_loans')->nullable();

            $table->float('sss_loan')->nullable();
            $table->float('hdmf_loan')->nullable();
            $table->float('hdmf_mp2')->nullable();
            
            
            $table->float('ar')->nullable();
            $table->string('ar_remarks')->nullable();

            $table->float('total_deductions')->nullable();
            $table->float('net_pay')->nullable();
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
