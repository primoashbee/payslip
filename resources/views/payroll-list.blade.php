@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of Payrolls</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Gross Pay</th>
                            <th>Net Pay</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php $ctr=0;?>
                            @foreach($payrolls as $payroll)
                            <?php $ctr++;?>
                            <tr>
                                <td>{{$ctr}}</td>
                                <td>{{$payroll->email}}</td>
                                <td>{{$payroll->name}}</td>
                                <td>{{$payroll->gross_pay}}</td>
                                <td>{{$payroll->net_pay}}</td>
                                
                                <td>
                                    {{$payroll->created_at->format('F d, Y')}},     
                                    <i> 
                                    {{$payroll->created_at->diffForHumans()}}
                                    </i>
                                </td>
                                <td>
                                    <a href="{{route('view.resend-payslip',$payroll->id)}}">
                                        <button class="btn btn-danger"><i class="fa fa-share" aria-hidden="true"></i></button>
                                    </a>
                                    <a href="{{route('view.payslip',$payroll->id)}}" target="_blank">
                                        <button class="btn btn-primary"><i class="fa  fa-file-pdf-o" aria-hidden="true"></i></button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
