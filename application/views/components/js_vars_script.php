<script>
    window.vars = (function () {
        const vars = <?= json_encode(script_vars(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

        return (key) => {
            if (!key) {
                return vars;
            }

            return vars[key] || undefined;
        };
    })();
</script>
