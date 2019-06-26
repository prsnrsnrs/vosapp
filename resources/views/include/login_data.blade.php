{{--
/**
 * ログインデータ
 * @params array $login_data
 */
--}}
<?php $confirm = isset($confirm) ? $confirm : false; ?>
@if (\App\Libs\Voss\VossAccessManager::isLogin())
  @if (\App\Libs\Voss\VossAccessManager::isAgent())
    <p>{{ \App\Libs\Voss\VossAccessManager::getAuth()['travel_company_name'] . \App\Libs\Voss\VossAccessManager::getAuth()['agent_name']}}</p>
    <p class="name">{{ \App\Libs\Voss\VossAccessManager::getAuth()['user_name'] }}</p>
  @endif
  <a href="{{ ext_route('logout') }}" class="{{ $confirm  ? 'prev_confirm' : ''}}">ログアウト</a>
@endif