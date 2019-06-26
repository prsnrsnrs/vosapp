@include('emails.include.header')

『インターネット予約決済サービス』パスワード再設定手続きについて

お客様のメールアドレスの送信を受け、自動的に当メールを送信いたしました。

このメールの送信時間より３０分以内に下記アドレスにアクセスして手続きをしてください。
https://voss.venus-cruise.co.jp/agent_test/user/password_reset?auth_key={!! $send_mail['mail_auth_key'] !!}

※３０分を経過するとアクセスできなくなります。
　その場合は、再度メールアドレスの送信から手続きしてください。

@include('emails.include.footer')