@extends('admin.layouts.main')

@section('title',  Translate::get('module_users::admin/main.action_edit') )

@section('content')
    <section class="box-typical">
        <header class="box-typical-header">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-title border-bottom">
                    <h3>{{ Translate::get('module_users::admin/main.action_edit') }}</h3>
                </div>
            </div>
        </header>
        <div class="box-typical-body pt-3 pb-3">
            <div class="table-responsive container">
                <div class="row">
                    <div class="col-12">
                        @if(isset($user))
                            @include('users::components.form', [$user, $init_permissions])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop