<form action="{{ route('admin.users.save', ['page' => (isset($user) && !empty($user->id)) ? $user->id : null]) }}"
      method="POST">
    @csrf
    <div class="form-group">
        <label for="email">{{ Translate::get('admin.input_email') }}:</label>
        <input class="form-control" id="email" name="email" type="email" value="{{ $user->email ?? old('email') }}">
    </div>

    <div class="form-group">
        <label for="name">{{ Translate::get('admin.input_name') }}:</label>
        <input class="form-control" id="name" name="name" type="name" value="{{ $user->name ?? old('name') }}">
    </div>

    @if ($user->id)
        <div class="password-change-block form-group">
            <button type="button" class="btn password-change-block__button">
                <i class="fa fa-key"></i>
                {{ Translate::get('admin.change_password') }}
                <span class="glyphicon glyphicon-chevron-down"></span>
            </button>

            <div class="password-change-block__fields pt-3">
                <div class="form-group">
                    <label for="password">{{ Translate::get('admin.input_password') }}:</label>
                    <input class="form-control" id="password" name="password" type="password" value="">
                </div>
                <div class="form-group">
                    <label for="passwordConfirmation">{{ Translate::get('admin.input_password_confirm') }}:</label>
                    <input class="form-control" id="passwordConfirmation" name="password_confirmation" type="password"
                           value="">
                </div>
            </div>
        </div>
    @else
        <div class="form-group">
            <label for="password">{{ Translate::get('admin.input_password') }}:</label>
            <input class="form-control" id="password" name="password" type="password" value="">
        </div>
        <div class="form-group">
            <label for="passwordConfirmation">{{ Translate::get('admin.input_password_confirm') }}:</label>
            <input class="form-control" id="passwordConfirmation" name="password_confirmation" type="password" value="">
        </div>
    @endif


    <section class="widget widget-time mt-4 user-permissions">
        <header class="widget-header-dark with-btn">
            {{ Translate::get('admin.module_permission_list') }}
            <button type="button" class="widget-header-btn btn user-permissions__change-state-all"
                    data-toggle="tooltip" data-placement="top"
                    data-original-title="{{ Translate::get('admin.check_uncheck_all_permissions') }}">
                <i class="font-icon font-icon-ok"></i>
            </button>
        </header>
        <div class="widget-time-content">
            <div class="row">
                @foreach ($permissions as $module => $permission)
                    <div class="col-md-4 col-lg-4">
                        <section class="card">
                            <header class="card-header">
                                {{ $module }}
                            </header>
                            <div class="card-block display-table text-left">
                                @foreach ($permission as $line)
                                    <div class="checkbox-toggle">
                                        <input type="checkbox"
                                               @if (in_array($line['name'], $init_permissions)) checked="checked"
                                               @endif class="user-permissions__input"
                                               name="user_permission[{{$line['name']}}]" value="{{$line['name']}}"
                                               id="{{$module}}_{{$line['name']}}">
                                        <label for="{{$module}}_{{$line['name']}}">{{Translate::get(strtolower($module).'::'.$line['i18n_name'])}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="form-group">
        <button class="btn btn-success" type="submit">
            {{ Translate::get('admin.input_save') }}
        </button>
    </div>
</form>