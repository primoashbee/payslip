@component('mail::message')
# Hello, {{$payroll->name}}!

Here's your payslip

The password for the attachment is: <b>{{$password}}</b>

Thanks,<br>
Finance and Accounting Department
@endcomponent
