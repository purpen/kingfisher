{{--<link href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.css" rel="stylesheet">--}}
{{--<link rel="stylesheet" href="https://cdn.bootcss.com/codemirror/4.10.0/codemirror.min.css">--}}
{{--<link rel="stylesheet" href="https://cdn.bootcss.com/highlight.js/8.4/styles/default.min.css">--}}
{{--<script src="https://cdn.bootcss.com/highlight.js/8.4/highlight.min.js"></script>--}}
{{--<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.js"></script>--}}
{{--<script src="https://cdn.bootcss.com/marked/0.3.2/marked.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdn.bootcss.com/codemirror/4.10.0/codemirror.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdn.bootcss.com/zeroclipboard/2.2.0/ZeroClipboard.min.js"></script>--}}

<link rel="stylesheet" href="{{ asset('plugin/editor/css/pygment_trac.css') }}">
<link rel="stylesheet" href="{{ asset('plugin/editor/css/editor.css') }}">
<link rel="stylesheet" href="{{ asset('plugin/editor/css/codemirror.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugin/editor/css/default.min.css') }}">
<script type="text/javascript" src="{{ asset('plugin/editor/js/highlight.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/modal.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/MIDI.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/bacheditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/highlight.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/marked.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/ZeroClipboard.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugin/editor/js/codemirror.min.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript" src="{{ asset('plugin/editor/js/bootstrap3-typeahead.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        url = "{{ url(config('editor.uploadUrl')) }}";

        @if(config('editor.ajaxTopicSearchUrl',null))
        ajaxTopicSearchUrl = "{{ url(config('editor.ajaxTopicSearchUrl')) }}";
        @else
        ajaxTopicSearchUrl = null;
        @endif

        var myEditor = new Editor(url,ajaxTopicSearchUrl);
        myEditor.render('#myEditor');
    });
</script>

<style>
    .editor{
        width:{{ config('editor.width') }};
    }
</style>