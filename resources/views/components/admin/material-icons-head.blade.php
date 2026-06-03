{{-- Load Material Symbols early; hide ligature text until the icon font is ready. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0..1,0&display=block"
>
<style>
    html:not(.material-icons-ready) .material-symbols-outlined {
        opacity: 0;
    }
</style>
<script>
    (function () {
        var root = document.documentElement;

        function markReady() {
            root.classList.add('material-icons-ready');
        }

        if (!document.fonts || !document.fonts.load) {
            markReady();
            return;
        }

        document.fonts.load('300 24px "Material Symbols Outlined"').then(markReady).catch(markReady);
        setTimeout(markReady, 3000);
    })();
</script>
