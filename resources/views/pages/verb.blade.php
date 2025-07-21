@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Playing with Verbs
                </div>

                <div class="panel-body">
                    @include('common.msgs')
                    @include('common.errors')

                    <form id="verbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="languageCode" id="languageCode" value="{{$languageCode}}" />

                        <div class="form-group">
                            <table class="vocal-table">
                                <tr>
                                    <th class="vocal-table-header">
                                        Verb
                                    </th>
                                    <th class="vocal-table-header">
                                        Tense
                                    </th>
                                    <th class="vocal-table-header">
                                        Person
                                    </th>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        @if(is_array($verb)){{$verb['infinitive']}}@else Not found @endif
                                    </td>
                                    <td class="vocal-table-entry vocal-table-tense">
                                        @if(is_array($tense)){{$tense['tense']}}@else Not found @endif
                                    </td>
                                    <td class="vocal-table-entry vocal-table-person">
                                        @if(is_array($person)){{$person['person']}}@else Not found @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="form-group-responses">

                            <input type="hidden" name="verbId" id="verbId" value="{{$verb['id']}}" />
                            <input type="hidden" name="infinitive" id="infinitive" value="{{$verb['infinitive']}}" />
                            <input type="hidden" name="tenseId" id="tenseId" value="{{$tense['id']}}" />
                            <input type="hidden" name="tense" id="tense" value="{{$tense['tense']}}" />
                            <input type="hidden" name="personId" id="personId" value="{{$person['id']}}" />
                            <input type="hidden" name="person" id="person" value="{{$person['person']}}" />

                            <table class="verb-response-table">
                                <tr>
                                    <td class="verb-response-table-prompt">
                                        Verb infinitive in english
                                    </td>
                                    <td class="verb-response-table-input">
                                        <input type="text" name="englishInfinitive" value="{{$englishInfinitive}}" id="englishInfinitive" class="response-text" />
                                        &nbsp;
                                        <span id="hint" style="display: none">{{$verb['english']}}</span>
                                    </td>
                                </tr>
                                <tr><td colspan="2" class="verb-response-table-sep">&nbsp;</td></tr>
                                <tr>
                                    <td class="verb-response-table-prompt">
                                        Verb conjugation in english
                                    </td>
                                    <td class="verb-response-table-input">
                                        <input type="text" name="englishConjugation" value="{{$englishConjugation}}" id="englishConjugation" class="response-text" />
                                    </td>
                                </tr>
                                <tr><td colspan="2" class="verb-response-table-sep">&nbsp;</td></tr>
                                <tr>
                                    <td class="verb-response-table-prompt">
                                        Verb conjugation in {{$currentLanguage->language}}
                                    </td>
                                    <td class="verb-response-table-input">
                                        <input type="text" name="foreignConjugation" value="{{$foreignConjugation}}" id="foreignConjugation" class="response-text" />
                                    </td>
                                </tr>
                                <tr><td colspan="2" class="verb-response-table-sep">&nbsp;</td></tr>
                                <tr>
                                    <td class="verb-response-table-prompt">
                                        Speak the conjugated phrase in {{$currentLanguage->language}}
                                    </td>
                                    <td class="verb-response-table-input">
                                        <input type="checkbox" name="speak" {{($speak!==null ? "checked='checked'": "")}} id="speak" class="response-text" /><span class="speak-help">(check when completed)</span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div style="text-align: right;padding-right: 15px;">
                                <button type="button" class="btn btn-default btn-vocal" onclick="goHome('verbForm', '{{ url('/home')}}')">
                                    <i class="fa fa-btn fa-home"></i>Home
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-vocal" onclick="showHint();">
                                    <i class="fa fa-btn fa-question"></i>Hint
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-vocal" onclick="checkAnswers();">
                                    <i class="fa fa-btn fa-check"></i>Check answers
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-vocal" onclick="getTenseDetails('{{$tenseDetail['pdf']}}');">
                                    <i class="fa fa-btn fa-check"></i>Tense details
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-vocal" onclick="nextVerb();">
                                    <i class="fa fa-btn fa-plus"></i>Next verb
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
            $('#verbForm').attr("action", "{{ url('checkAnswers')}}");
            $('#verbForm').submit();
        }

        function nextVerb() {
            $('#verbForm').attr("action", "{{ url('nextVerb')}}");
            $('#verbForm').submit();
        }

        function getTenseDetails(pdf) {
            $('#embedId').attr('src', pdf);
            $('#popup-modal').appendTo("body").modal('show');
        }

        /**
         * It wasn't necessary to run this function, as the pdf url was available locally
         * but this did in fact work
         * @param pdf
         */
        function experimental(pdf) {
            $.ajax({
                url: 'getTenseDetails',
                dataType: 'json',
                data: {'pdf': pdf},
                success: function (response) {
                    let data = response.data;
                    if (data != '') {
                        $('#embedId').attr('src', data);
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                }
            });
        };

        $(document).ready( function()
        {

        });
    </script>
@endsection
