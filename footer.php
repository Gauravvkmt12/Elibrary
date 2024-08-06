<footer class="footer bg-danger">
    <div class="text-center">
        <p class="text-white">&copy; <span id="year"></span> Elibrary. All rights reserved.</p>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var yearSpan = document.getElementById('year');
    var currentYear = new Date().getFullYear();
    yearSpan.textContent = currentYear;
});
</script>
<style>
    .footer p {
    margin: 0;
    font-size: 1.3em;
}
@media (min-width:1199px) {
    .footer{position: fixed;bottom:0;width: 100%;}
    body{height: 100vh;}
}
</style>