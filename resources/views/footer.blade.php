<footer class="absolute bottom-0 py-2 px-4 w-full text-center">
    <small class="opacity-70">
        {{ config('app.name') }} v{{ $footer->version() }}
    </small>
    <small class="opacity-50">|</small>
    <small class="opacity-70 text-primary-500 hover:underline">
        <a href="https://status.hydephp.com/" target="_blank" rel="nofollow noopener noreferrer">Global Status Page</a>
    </small>
</footer>
