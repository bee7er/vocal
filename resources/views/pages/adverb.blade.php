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
                    <!-- Display Msgs -->
                    @include('common.msgs')
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                            <!-- New Task Form -->
                    <form id="adverbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="form-group-adverb">
                                <table class="adverb-table">
                                    <tr>
                                        <th class="adverb-table-header">
                                            Adverb
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="adverb-table-entry adverb-table-verb">
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
                                            <input type="text" name="englishAdverb" value="{{$englishAdverb}}" id="englishAdverb" class="response-text" />
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
                                <button type="button" class="btn btn-default btn-adverb" onclick="showHint();">
                                    <i class="fa fa-btn fa-question"></i>Hint
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
            $('#adverbForm').attr("action", "{{ url('checkAdverbAnswers')}}");
            $('#adverbForm').submit();
        }

        function nextAdverb() {
            $('#adverbForm').attr("action", "{{ url('nextAdverb')}}");
            $('#adverbForm').submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
