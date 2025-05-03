function scrollToApps() {
    const target = document.getElementById('about');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
}
