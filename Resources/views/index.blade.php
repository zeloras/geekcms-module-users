@extends('admin.layouts.main')

@section('title',  \Translate::get('users::admin/sidenav.name') )

@section('content')
<section class="box-typical container pb-3">
    <header class="box-typical-header">
        <div class="tbl-row">
            <div class="tbl-cell tbl-cell-title">
                <h3>{{ \Translate::get('users::admin/sidenav.name') }}</h3>
            </div>
            <div class="tbl-cell tbl-cell-action-bordered">
                <a href="{{ route('admin.users.create') }}"
                   data-toggle="tooltip" data-placement="left"
                   data-original-title="{{ \Translate::get('users::admin/main.create_user') }}" class="action-btn">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="tbl-cell tbl-cell-action-bordered">
                <button type="button" data-token="{!! csrf_token() !!}"
                        data-toggle="tooltip" data-placement="left"
                        data-original-title="{{ \Translate::get('users::admin/main.delete_selected') }}"
                        data-text="Are you sure?" data-inputs=".delete-item-check:checked"
                        data-action="{{ route('admin.users.delete.all') }}"
                        class="action-btn delete-all">
                    <i class="font-icon font-icon-trash"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="box-typical-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-custom">
                <thead>
                <tr>
                    <th class="table-check"></th>
                    <th class="table-title">{{ \Translate::get('users::admin/main.name') }}</th>
                    <th>{{ \Translate::get('users::admin/main.email') }}</th>
                    <th>{{ \Translate::get('users::admin/main.created_at') }}</th>
                    <th class="table-icon-cell table-actions"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $element)
                    <tr>
                        <td class="table-check">
                            <div class="checkbox checkbox-only">
                                <input type="checkbox" class="delete-item-check" id="table-check-{{ $element->id }}" value="{{ $element->id }}">
                                <label for="table-check-{{ $element->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', ['user' => $element->id]) }}">
                                {{ $element->name }}
                            </a>
                        </td>
                        <td class="color-blue-grey-lighter">
                            {{ $element->email }}
                        </td>
                        <td class="table-date">{{ $element->created_at }} <i class="font-icon font-icon-clock"></i></td>
                        <td class="table-icon-cell">
                            <a href="{{ route('admin.users.edit', ['user' => $element->id]) }}"
                               data-toggle="tooltip" data-placement="left"
                               data-original-title="{{ \Translate::get('users::admin/main.action_edit') }}"
                               class="btn-link btn btn-success-outline btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.users.delete', ['user' => $element->id]) }}"
                               data-toggle="tooltip" data-placement="left"
                               data-original-title="{{ \Translate::get('module_pages::admin/main.list.action_delete') }}"
                               class="btn-link btn btn-success-outline btn-sm"
                               data-delete="{{ \Translate::get('users::admin/main.action_delete_confirm') }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
