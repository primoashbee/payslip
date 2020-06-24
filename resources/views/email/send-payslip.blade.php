@slot('footer')
    @component('mail::footer')
    <img src="{{$logo}}" class="logo" alt="LIGHT Logo">
    @endcomponent
@endslot

@component('mail::message')
# Hello, {{$payroll->name}}!

Here's your payslip for the period of <b> {{$payroll->applicable }}</b>

The password for the attachment is: <b>{{$password}}</b>

Thanks,<br>

Finance and Accounting Department <br>
<img src="https://payslip.light.org.ph/get/logo?id={{$payroll->id}}" style="max-width:20%">
@endcomponent
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ $company_name }}. All rights reserved.
    @endcomponent
@endslot
