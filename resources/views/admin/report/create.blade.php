@extends('layouts.admin.master')
@section('pageTitle', 'Buat Laporan Baru')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buat Laporan Baru</h4>
                </div>
                <div class="card-body">
                    @include('admin.report.form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection