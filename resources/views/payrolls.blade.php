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
                            <th>Batch ID</th>
                            <th>Covers</th>
                            <th>Uploaded By</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php $ctr=0;?>
                            @foreach($payrolls as $payroll)
                            <?php $ctr++;?>
                            <tr>
                                <td>{{$ctr}}</td>
                                <td>{{$payroll->batch_id}}</td>
                                <td>{{$payroll->applicable}}</td>
                                <td>
                                    {{$payroll->user->name}}
                                </td>
                                <td>
                                    <a href="{{route('payrolls.batch_id',$payroll->batch_id)}}">View</a>
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
