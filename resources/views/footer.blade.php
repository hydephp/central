<footer class="mt-auto py-2 px-4 text-center">
    <small class="opacity-70">
        {{ config('app.name') }} <small>v</small><code class="font-mono">{{ $footer->version() }}</code> <small id="version-status" class="opacity-70"></small>
    </small>
    <small class="opacity-50">|</small>
    <small class="opacity-70 text-primary-500 hover:underline">
        <a href="https://status.hydephp.com/" target="_blank" rel="nofollow noopener noreferrer">Global Status Page</a>
    </small>

    <script>
        // Async script to check if version is up-to-date, without slowing down the main request
        document.addEventListener("DOMContentLoaded", async function () {
            // Replace these variables with your GitHub repository details
            const currentCommitHash = '{{ $footer->version() }}';
            const isLocal = {{ app('env') === 'local' ? 'true' : 'false' }};
            const label = document.getElementById('version-status');
            let match = null;

            try {
                // Fetch the latest commit from the GitHub API
                const response = await fetch(`https://api.github.com/repos/hydephp/central/commits/main`);
                const data = await response.json();
                const sha = data.sha.slice(0, 7);

                match = sha === currentCommitHash;
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
