@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Home Page Actions
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                            <!-- New Task Form -->
                    <form id="homeForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="languageCode" id="languageCode" value="{{$languageCode}}" />

                        <!-- Action Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" onclick="playWithVerbs();">
                                    <i class="fa fa-btn fa-plus"></i>Play with verbs
                                </button>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" onclick="playWithAdverbs();">
                                    <i class="fa fa-btn fa-plus"></i>Play with adverbs
                                </button>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" onclick="playWithAdjectives();">
                                    <i class="fa fa-btn fa-plus"></i>Play with adjectives
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
        function playWithVerbs() {
            $('#homeForm').attr("action", "{{ url('verb')}}");
            $('#homeForm').submit();
        }

        function playWithAdverbs() {
            $('#homeForm').attr("action", "{{ url('adverb')}}");
            $('#homeForm').submit();
        }

        function playWithAdjectives() {
            $('#homeForm').attr("action", "{{ url('adjective')}}");
            $('#homeForm').submit();
        }
    </script>
@endsection
