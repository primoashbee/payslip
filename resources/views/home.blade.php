@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

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
                    <form action="{{route('upload.payroll')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <p> See Uploaded Information <a href="{{route('payroll.list')}}">here</a> </p>
                        <p class="float-right"> Download template  <a href="{{route('download.template')}}">Here </a></p>
                        
                        <div class="form-group">
                          <label for="uploadFile">Upload template</label>
                          <input type="file" class="form-control-file" id="uploadFile" name="uploadFile" accept=".xlsx" required>
                        </div>
                        
                        <input type="submit" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<notification-alert></notification-alert>
@endsection
