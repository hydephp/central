<footer class="mt-auto py-2 px-4 text-center mx-auto w-full">
    <div class="lg:-ms-[--sidebar-width]">
        <small class="opacity-70">
            {{ config('app.name') }} <small>v</small><code class="font-mono">{{ $footer->version() }}</code>
        </small>
        <small class="opacity-50">|</small>
        <small class="opacity-70 text-primary-500 hover:underline">
            <a href="{{ url('terms-of-service') }}">Terms of Service</a>
        </small>
        <small class="opacity-50">|</small>
        <small class="opacity-70 text-primary-500 hover:underline">
            <a href="https://status.hydephp.com/" target="_blank" rel="nofollow noopener noreferrer">Global Status Monitor</a>
        </small>
    </div>
</footer>
