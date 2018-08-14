<p>Hello <i>{{ $mail->user }}</i>,</p>

<p>You received this email because your ticket 
with ticket #{{ $mail->ticketnum }} is accepted 
by {{ $mail->tech }}. Please click button below to view ticket details.</p>

<a href="{{ env('APP_URL').$mail->url }}" class="button button-blue" target="_blank" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">View Ticket</a>

<p>Have a nice day!</p>

<hr>

<p class='text-muted'>
    If you’re having trouble clicking the "View Ticket" button, 
    copy and paste the URL below into your web browser: <a href='{{ env('APP_URL').$mail->url }}'>{{ env('APP_URL').$mail->url }}</a>
</p>