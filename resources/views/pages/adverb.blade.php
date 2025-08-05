@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Playing with Adverbs
                </div>

                <div class="panel-body">
                    @include('common.msgs')
                    @include('common.errors')

                    <form id="adverbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="form-group-adverb">
                                <table class="vocal-table">
                                    <tr>
                                        <th class="vocal-table-header">
                                            Adverb
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="vocal-table-entry center-entry">
                                            @if(is_array($adverb)){{$adverb['adverb']}}@else Not found @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group-responses">

                                <input type="hidden" name="adverbId" id="adverbId" value="{{$adverb['id']}}" />
                                <input type="hidden" name="english" id="english" value="{{$adverb['english']}}" />

                                <table class="adverb-response-table">
                                    <tr>
                                        <td class="adverb-response-table-prompt">
                                            Adverb in english
                                        </td>
                                        <td class="adverb-response-table-input">
                                            <input type="text" name="englishAdverb" value="{{$englishAdverb}}" id="englishAdverb" title="Adverb in english" class="response-text" />
                                            &nbsp;
                                            <span id="hint" style="display: none">{{$adverb['english']}}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div style="text-align: right;padding-right: 15px;">
                                <button type="button" class="btn btn-default btn-adverb" onclick="goHome('adverbForm', '{{ url('/home')}}');">
                                    <i class="fa fa-btn fa-home"></i>Home
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adverb" onclick="editAdverb('adverbForm', '{{ url('/editAdverb')}}');">
                                    <i class="fa fa-btn fa-pencil"></i>Edit
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adverb" onclick="showHint();">
                                    <i class="fa fa-btn fa-question"></i>Hint
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-vocal"
                                        onclick="openTranslationWindow('en', '{{$adverb['lang']}}', $('#englishAdverb'));">
                                    <i class="fa fa-btn fa-question"></i>Get translation
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adverb" onclick="checkAnswers();">
                                    <i class="fa fa-btn fa-check"></i>Check answers
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-adverb" onclick="nextAdverb();">
                                    <i class="fa fa-btn fa-plus"></i>Next adverb
                                </button>
                            </div>
                        </div>

                        <!-- Tip -->
                        <div class="form-group">
                            <div class="translate-wdw-tip">
                                {{$translateWdwTip}}
                            </div>
                        </div>
                    </form>
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
            $('#adverbForm').attr("action", "{{ url('checkAdverbAnswers')}}").submit();
        }

        function nextAdverb() {
            $('#adverbForm').attr("action", "{{ url('nextAdverb')}}").submit();
        }

        function editAdverb() {
            $('#adverbForm').attr("action", "{{ url('/editAdverb') }}").submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
