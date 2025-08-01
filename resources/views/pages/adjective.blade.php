@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Playing with Adjectives
                </div>

                <div class="panel-body">
                    @include('common.msgs')
                    @include('common.errors')

                    <form id="adjectiveForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="form-group-adjective">
                                <table class="vocal-table">
                                    <tr>
                                        <th class="vocal-table-header">
                                            Adjective
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="vocal-table-entry center-entry">
                                            @if(is_array($adjective)){{$adjective['adjective']}}@else Not found @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group-responses">

                                <input type="hidden" name="adjectiveId" id="adjectiveId" value="{{$adjective['id']}}" />
                                <input type="hidden" name="english" id="english" value="{{$adjective['english']}}" />

                                <table class="adjective-response-table">
                                    <tr>
                                        <td class="adjective-response-table-prompt">
                                            Adjective in english
                                        </td>
                                        <td class="adjective-response-table-input">
                                            <input type="text" name="englishAdjective" value="{{$englishAdjective}}" id="englishAdjective" title="Adjective in english" class="response-text" />
                                            &nbsp;
                                            <span id="hint" style="display: none">{{$adjective['english']}}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div style="text-align: right;padding-right: 15px;">
                                <button type="button" class="btn btn-default btn-adjective" onclick="goHome('adjectiveForm', '{{ url('/home')}}');">
                                    <i class="fa fa-btn fa-home"></i>Home
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adjective" onclick="showHint();">
                                    <i class="fa fa-btn fa-question"></i>Hint
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-vocal"
                                        onclick="openTranslationWindow('en', '{{$adjective['lang']}}', $('#englishAdjective'));">
                                    <i class="fa fa-btn fa-question"></i>Get translation
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adjective" onclick="checkAnswers();">
                                    <i class="fa fa-btn fa-check"></i>Check answers
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adjective" onclick="nextAdjective();">
                                    <i class="fa fa-btn fa-plus"></i>Next adjective
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tip -->
                    <div class="form-group">
                        <div class="translate-wdw-tip">
                            {{$translateWdwTip}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        function showHint() {
            $('#hint').toggle();
        }

        function checkAnswers() {
            $('#adjectiveForm').attr("action", "{{ url('checkAdjectiveAnswers')}}");
            $('#adjectiveForm').submit();
        }

        function nextAdjective() {
            $('#adjectiveForm').attr("action", "{{ url('nextAdjective')}}");
            $('#adjectiveForm').submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
