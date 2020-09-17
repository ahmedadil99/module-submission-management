@if (Auth::user()->hasRole('writer'))
  @include('common.nav.writer_nav')
@endif

@if (Auth::user()->hasRole('publisher'))
  @include('common.nav.publisher_nav')
@endif