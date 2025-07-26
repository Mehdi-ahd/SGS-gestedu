
@extends('layouts.app')

@section('title', 'Messagerie')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Messagerie</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMessageModal">
            <i class="fas fa-plus me-2"></i>Nouveau message
        </button>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Conversations</h6>
                </div>
                <div class="card-body">
                    <!-- Liste des conversations -->
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
                </div>
                <div class="card-body">
                    <!-- Zone de messages -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
