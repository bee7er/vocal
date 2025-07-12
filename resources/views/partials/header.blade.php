
<div id="top">&nbsp;</div>

<div class="row logo-menu-container">

    <div class="header-block">
        @if(isset($languages) && count($languages)>0)
            {{$flag = null}}
            <select id="languageCode" onchange="changeLanguage(this.value)">
            @foreach($languages as $languageEntry)
                <option value="{{$languageEntry->code}}"
                        @if($languageCode == $languageEntry->code)
                            {{$flag = $languageEntry->flag}}
                            selected
                        @endif
                >{{$languageEntry->language}}</option>
            @endforeach
            </select>
            @if($flag)
                &nbsp;<img id="nationalFlag" src="{{config('app.base_url')}}{{$flag}}" width="30px" />
            @endif
        @else
            No languages found
        @endif
    </div>

</div>

@section('global-scripts')
    <script type="text/javascript">


    </script>
@endsection
