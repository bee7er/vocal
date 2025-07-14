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
                    <!-- Display Msgs -->
                    @include('common.msgs')
                            <!-- Display Validation Errors -->
                    @include('common.errors')

                            <!-- New Task Form -->
                    <form id="verbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="languageCode" id="languageCode" value="{{$languageCode}}" />

                        <div class="form-group">
                            <table class="verb-table">
                                <tr>
                                    <th class="verb-table-header">
                                        Verb
                                    </th>
                                    <th class="verb-table-header">
                                        Tense
                                    </th>
                                    <th class="verb-table-header">
                                        Person
                                    </th>
                                </tr>
                                <tr>
                                    <td class="verb-table-entry verb-table-verb">
                                        @if(is_array($verb)){{$verb['infinitive']}}@else Not found @endif
                                    </td>
                                    <td class="verb-table-entry verb-table-tense">
                                        @if(is_array($tense)){{$tense['tense']}}@else Not found @endif
                                    </td>
                                    <td class="verb-table-entry verb-table-person">
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
                                <button type="button" class="btn btn-default btn-verb" onclick="goHome('verbForm', '{{ url('/')}}')">
                                    <i class="fa fa-btn fa-home"></i>Home
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-verb" onclick="showHint();">
                                    <i class="fa fa-btn fa-question"></i>Hint
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-verb" onclick="checkAnswers();">
                                    <i class="fa fa-btn fa-check"></i>Check answers
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-default btn-verb" onclick="nextVerb();">
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

        $(document).ready( function()
        {

        });
    </script>
@endsection
