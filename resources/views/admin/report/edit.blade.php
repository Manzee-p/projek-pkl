@extends('layouts.admin.master')
@section('pageTitle', 'Edit Laporan')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Laporan #{{ $report->id }}</h4>
                </div>
                <div class="card-body">
                    @include('admin.report.form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection