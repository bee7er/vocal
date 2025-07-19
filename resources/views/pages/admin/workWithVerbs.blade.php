@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="index-title">
                        Work with Verbs
                    </div><div class="index-action">
                        <button type="submit" class="btn btn-default" onclick="addVerb();">
                            <i class="fa fa-btn fa-plus"></i>Add
                        </button>
                    </div>
                </div>

                <div class="panel-body">
                    @include('common.msgs')
                    @include('common.errors')

                    <form id="verbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="languageCode" id="languageCode" value="{{$languageCode}}" />
                        <input type="hidden" name="verbId" id="verbId" value="" />


                        <div class="panel-heading">
                            Position to: <input type="text" class="input-position" name="position" id="position" value="{{$position}}" />
                            <button type="submit" class="btn btn-default input-position" onclick="searchVerb();">
                                <i class="fa fa-btn fa-question"></i>Position
                            </button>
                        </div>

                        <div class="form-group">
                            <table class="verb-table">
                                <tr>
                                    <th class="verb-table-header">
                                        Verb
                                    </th>
                                    <th class="verb-table-header">
                                        English
                                    </th>
                                    <th class="verb-table-header">
                                        Language
                                    </th>
                                    <th class="verb-table-header">
                                        Action
                                    </th>
                                </tr>
                                @if(isset($verbs) && count($verbs)>0)
                                    @foreach($verbs as $verbEntry)
                                        <tr>
                                            <td class="verb-table-entry verb-table-verb">
                                                {{$verbEntry->infinitive}}
                                            </td>
                                            <td class="verb-table-entry verb-table-verb">
                                                {{$verbEntry->english}}
                                            </td>
                                            <td class="verb-table-entry verb-table-verb">
                                                {{$verbEntry->lang}}
                                            </td>
                                            <td class="verb-table-entry verb-table-verb">
                                                <button type="submit" class="btn btn-default" onclick="editVerb({{$verbEntry->id}});">
                                                    <i class="fa fa-btn fa-pencil"></i>Edit
                                                </button>
                                                <button type="submit" class="btn btn-default" onclick="deleteVerb({{$verbEntry->id}});">
                                                    <i class="fa fa-btn fa-exclamation"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    No verbs found
                                @endif
                            </table>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div style="text-align: right;padding-right: 15px;">
                                <button type="button" class="btn btn-default btn-verb" onclick="goHome('verbForm', '{{ url('/home')}}')">
                                    <i class="fa fa-btn fa-home"></i>Home
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
        function addVerb() {
            $('#verbId').val(null);
            $('#verbForm').attr("action", "{{ url('/addVerb') }}").submit();
        }

        function editVerb(verbId) {
            $('#verbId').val(verbId);
            $('#verbForm').attr("action", "{{ url('/editVerb') }}").submit();
        }

        function deleteVerb(verbId) {
            $('#verbId').val(verbId);
            $('#verbForm').attr("action", "{{ url('/deleteVerb') }}").submit();
        }

        function searchVerb() {
            $('#verbForm').attr("action", "{{ url('/workWithVerbs') }}/" + $('#position').val()).submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
