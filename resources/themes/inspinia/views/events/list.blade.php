@extends('layout')

@section('content')
    <div id="app"></div>
@endsection

@section('scripts')
<script>
    let search = '{{ $search }}';
    let events = {!! json_encode($events) !!};
    let massDeleteUrl = '{{ url('events/mass-delete') }}';
</script>

<script src="{{ asset('assets/js/events-list.js') }}"></script>
@endsection
