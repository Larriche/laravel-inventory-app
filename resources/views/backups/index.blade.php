@extends('layouts.app')

@section('title')
    Back Ups
@endsection

@section('page_title')
    Back ups
@endsection

@section('content') 
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p class="undertext">Here you make backups and recover data</p> 
                        </div>
                    </div>
                </div>

                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-6">
                            @include('errors.form_errors')
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                             <form method="POST" action="/backup" id="backups-form">
                                 {{ csrf_field() }}

                                <div class="row">
                                    <p class="form-info">Generate back up file for download</p>
                                </div>

                                <div class="form-group">
                                    <button  type    = "submit"
                                            class   = "btn btn-success btn-block form-control" 
                                             id="backup-form-button">
                                             <i class="fa fa-download"></i> 
                                             BACK UP DATABASE
                                    </button>
                                </div>
                             </form>
                        </div>

                        <div class="col-md-4">
                             <div class="row">
                                <p class="form-info">Restore database from a back up</p>
                            </div>

                            <button class="btn  btn-primary btn-block" data-toggle="modal" data-target="#restore-modal"><i class="fa fa-upload"></i> RESTORE DATABASE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backups.modals')
@endsection

@section('scripts')
<script src="/js/backups.js"></script>
@endsection

