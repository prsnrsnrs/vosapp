<!-- インフォメーション -->
<div class="info" style="@if(empty($info) && !session()->has('success_message')) display: none; @endif">
  @if (session()->has('success_message'))
    <p class="icon icon_success" style="margin: 8px 0"></p>
    <p class="message"><span class="success">{!! session()->get('success_message') !!}</span></p>
  @else
    <p class="icon icon_info" style="margin: 8px 0"></p>
    <p class="message">{!! $info !!}</p>
  @endif
</div>

