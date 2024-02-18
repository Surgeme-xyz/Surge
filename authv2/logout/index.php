<html>
<head>
<script>
document.cookie = "surge-token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

const queryParams = new URLSearchParams(window.location.search);
const forwardParam = queryParams.get('forward');

if (forwardParam) {
    window.location.href = '/authv2/?forward=' + forwardParam;
} else {
    window.location.href = '/authv2';
}
</script>
</head>
<body>
Javascript is required.
<a href='/'>Click here if you are not redirected.</a>
</body>
</html>