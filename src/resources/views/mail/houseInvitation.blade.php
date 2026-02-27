<main>
    <div>
        <div class="text-center">
            <h1>House invitation</h1>
        </div>
        <div class="flex flex-col, ga4 font-semibold">
            <p>{{ $invitation->sender->fullname() }} would like to invite you to his share-house.</p>
            <p>Just click the link bellow to navigate to our site and accept or refuse the invitation :</p>
            <a href="http://127.0.0.1:8000/invite/{{ $invitation->token }}/response " class="text-purple-600"> EasyColoc.com</a>
        </div>
    </div>
</main>
