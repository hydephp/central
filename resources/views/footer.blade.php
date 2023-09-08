<footer class="absolute bottom-0 py-2 px-4 w-full text-center">
    <small class="opacity-70">
        {{ config('app.name') }} v{{ $footer->version() }} <small id="verson-status" class="opacity-70"></small>
    </small>
    <small class="opacity-50">|</small>
    <small class="opacity-70 text-primary-500 hover:underline">
        <a href="https://status.hydephp.com/" target="_blank" rel="nofollow noopener noreferrer">Global Status Page</a>
    </small>

    <script>
        // Async script to check if version is up to date, without slowing down the main request
        document.addEventListener("DOMContentLoaded", async function () {
            // Replace these variables with your GitHub repository details
            const owner = 'hydephp';
            const repo = 'central';
            const suppliedCommitHash = '{{ $footer->version() }}';
            const isLocal = {{ app('env') === 'local' ? 'true' : 'false' }};
            const label = document.getElementById('verson-status');
            let match = null;

            try {
                // Fetch the latest commit from the GitHub API
                const response = await fetch(`https://api.github.com/repos/${owner}/${repo}/commits/main`);
                const data = await response.json();
                const sha = data.sha.slice(0, 7);

                match = sha === suppliedCommitHash;
            } catch (error) {
                console.error("Error fetching data from GitHub API:", error);
            }

            if (match) {
                label.innerText = '(Latest)';
            } else {
                if (isLocal) {
                    label.innerText = '(Local)';
                } else {
                    label.innerText = '(Out of date)';
                }
            }
        });

    </script>
</footer>
