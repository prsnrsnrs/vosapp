{{--
/**
 * パンくず
 * @params array $breadcrumbs
 */
--}}

@foreach ($breadcrumbs as $breadcrumb)
  @if (array_get($breadcrumb, 'url'))
    <a href="{{array_get($breadcrumb, 'url')}}"
       class="{{ array_get($breadcrumb, 'confirm', false) ? 'prev_confirm' : ''}}">{{$breadcrumb['name']}}</a>
  @else
    <span>{{$breadcrumb['name']}}</span>
  @endif

  @if (!$loop->last)<span>＞</span>@endif
@endforeach