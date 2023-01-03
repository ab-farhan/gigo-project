@php
    use App\Models\User\Language;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    $userDefaultLang = Language::where([
        ['user_id',Auth::guard('web')->user()->id],
        ['is_default',1]
    ])->first();
    $userLanguages = Language::where('user_id',Auth::guard('web')->user()->id)->get()
@endphp
@if(!is_null($userDefaultLang))
    @if (!empty($userLanguages))
        <select name="userLanguage" class="form-control"
                onchange="window.location='{{url()->current() . '?language='}}'+this.value">
            <option value="" selected disabled>{{__('Select a Language')}}</option>
            @foreach ($userLanguages as $lang)
                <option
                    value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
            @endforeach
        </select>
    @endif
@endif
